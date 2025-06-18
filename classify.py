#!/usr/bin/env python3
import os
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'
os.environ['TF_ENABLE_ONEDNN_OPTS'] = '0'

import sys, json, io, base64
import numpy as np
from PIL import Image
import tensorflow as tf
import matplotlib.pyplot as plt
import matplotlib
matplotlib.use('Agg')  # Disable interactive backend

# CONFIG
MODEL_PATH = 'beans_efffnetb3.keras'
class_names = ['defective','good','ripe','underripe']

# Load model
model = tf.keras.models.load_model(MODEL_PATH)

# Preprocessing
def preprocess(img_path, size=(224,224)):
    img = Image.open(img_path).convert('RGB').resize(size)
    arr = tf.keras.applications.efficientnet.preprocess_input(np.array(img))
    return np.expand_dims(arr,0), np.array(img.resize(size))

# Grad-CAM generator
def generate_gradcam(img_array, last_conv_layer_name, pred_index=None):
    grad_model = tf.keras.models.Model(
        [model.inputs],
        [model.get_layer(last_conv_layer_name).output, model.output]
    )

    with tf.GradientTape() as tape:
        conv_outputs, predictions = grad_model(img_array)
        if pred_index is None:
            pred_index = tf.argmax(predictions[0])
        output = predictions[:, pred_index]

    grads = tape.gradient(output, conv_outputs)
    pooled_grads = tf.reduce_mean(grads, axis=(0, 1, 2))
    conv_outputs = conv_outputs[0]
    heatmap = conv_outputs @ pooled_grads[..., tf.newaxis]
    heatmap = tf.squeeze(heatmap)

    heatmap = tf.maximum(heatmap, 0) / tf.math.reduce_max(heatmap)
    return heatmap.numpy()

# Overlay heatmap on image
def overlay_heatmap(img, heatmap, alpha=0.4):
    heatmap = np.uint8(255 * heatmap)
    jet = plt.get_cmap("jet")
    colored = jet(heatmap)[:, :, :3]
    colored = Image.fromarray(np.uint8(colored * 255)).resize(img.size)
    blended = Image.blend(img.convert('RGB'), colored, alpha)
    return blended

def main():
    if len(sys.argv) < 3:
        print(json.dumps({'error': 'Usage: classify.py <img_path> <threshold>'}))
        sys.exit(1)

    img_path = sys.argv[1]
    threshold = float(sys.argv[2])

    # Prediction
    batch, raw_img = preprocess(img_path)
    predictions = model.predict(batch)
    class_idx = int(np.argmax(predictions[0]))
    confidence = float(predictions[0][class_idx])
    verdict = class_names[class_idx] if confidence >= threshold else 'uncertain'

    # Grad-CAM heatmap (based on last conv layer)
    heatmap = generate_gradcam(batch, last_conv_layer_name='top_conv')
    heatmap_img = overlay_heatmap(Image.fromarray(raw_img), heatmap)

    # Encode to Base64
    buf = io.BytesIO()
    heatmap_img.save(buf, format='PNG')
    heatmap_base64 = base64.b64encode(buf.getvalue()).decode('utf-8')

    # Build response
    class_probs = {
        class_names[i]: round(float(p), 4)
        for i, p in enumerate(predictions[0])
    }

    print(json.dumps({
        'label': class_names[class_idx],
        'confidence': round(confidence, 4),
        'verdict': verdict,
        'heatmap': heatmap_base64,
        'probs': class_probs
    }))

if __name__ == '__main__':
    main()

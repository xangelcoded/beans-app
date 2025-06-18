===============================
 B.E.A.N.S. PROJECT – SETUP GUIDE
===============================

"Bean Evaluation & Analytics via Neural System" (B.E.A.N.S.) is a web app that uses a deep learning model to classify coffee beans (ripe, underripe, defective, good) through uploaded images. It runs locally using:
- PHP & MySQL (via XAMPP)
- Python (EfficientNet-B3 model)
- Grad-CAM heatmaps for explainability
- Cropping tool (CropperJS)
- A database to log all classifications

=========================================================
 STEP 1: DOWNLOAD OR CLONE THE B.E.A.N.S. PROJECT FILES
=========================================================

A. GitHub Method:
------------------
1. Go to the GitHub repository (if available):  
   👉 https://github.com/xangelcoded/beans-app.git
2. Click the green [Code] button → choose [Download ZIP]

3. Extract the ZIP file. It should contain:
   - classify.py
   - pages/ folder
   - beans.sql
   - uploads/ folder (can be empty)
   - index.php
   - connections.php
   - etc.

B. Manual ZIP Method:
---------------------
If you were given the project in ZIP format:
1. Extract the ZIP file to any folder.
2. Rename the folder to: `beans-classifier`

===================================================================
 STEP 2: INSTALL AND SET UP XAMPP FOR PHP + MYSQL DATABASE SERVER
===================================================================

1. Download XAMPP from:
   👉 https://www.apachefriends.org/index.html

2. Install XAMPP with default settings.

3. Launch **XAMPP Control Panel**.

4. Start **Apache** and **MySQL**.

   [✔] Apache – Running  
   [✔] MySQL – Running

5. Open your browser and visit:
   👉 http://localhost/phpmyadmin

=========================================================
 STEP 3: IMPORT THE BEANS DATABASE (beans.sql) TO XAMPP
=========================================================

1. In phpMyAdmin (http://localhost/phpmyadmin):
   a. Click "New" on the left sidebar  
   b. Enter database name: `beans`  
   c. Click [Create]

2. After database is created:
   a. Click the database `beans` in the left sidebar  
   b. Click the [Import] tab

3. Click [Choose File] and select the file:
   👉 beans-classifier/beans.sql

4. Click [Go]

✅ The database is now imported with all tables and data.

=========================================
 STEP 4: MOVE PROJECT TO XAMPP HTDOCS FOLDER
=========================================

1. Copy the entire folder `beans-classifier`

2. Paste it inside:
   👉 C:\xampp\htdocs\

3. You should now have:
   👉 C:\xampp\htdocs\beans-classifier\

4. To test, go to:
   👉 http://localhost/beans-classifier/

✅ You should see the login page or dashboard.

==================================================
 STEP 5: DOWNLOAD & PLACE THE AI MODEL (.keras file)
==================================================

1. Download the trained model from this link:
   👉 https://nationalueduph-my.sharepoint.com/:u:/g/personal/malaluanae_students_nu-lipa_edu_ph/EePeBHtWtlZOgNTzmuAxhwcBaGTFB9H_VeWzdVgvhFM3ow?e=3Bkcns

2. Download file:
   👉 beans_efffnetb3.keras

3. Move the file to this folder:
   👉 C:\xampp\htdocs\beans-classifier\pages\

✅ Final path should be:
   C:\xampp\htdocs\beans-classifier\pages\beans_efffnetb3.keras

====================================================
 STEP 6: INSTALL PYTHON AND REQUIRED LIBRARIES
====================================================

1. Download and install Python 3 (if not yet installed):
   👉 https://www.python.org/downloads/

2. After installation, open **Command Prompt** and run:

python --version
pip --version
(You should see Python version like 3.x.x and pip working.)

Navigate to the project folder:

cd C:\xampp\htdocs\beans-classifier
Install required libraries:

pip install tensorflow numpy pillow matplotlib
(Optional but recommended: Use a virtual environment.)

python -m venv venv
venv\Scripts\activate   (on Windows)
source venv/bin/activate (on Mac/Linux)

pip install tensorflow numpy pillow matplotlib
=======================================================
STEP 7: UNDERSTAND classify.py (Python Classifier Script)
🧠 This script does the following:

Loads the EfficientNet model (beans_efffnetb3.keras)

Accepts an image file and threshold

Runs prediction and applies Grad-CAM

Outputs:

Predicted label

Confidence scores

Grad-CAM heatmap saved to disk

JSON response to PHP

📁 File location:
👉 C:\xampp\htdocs\beans-classifier\classify.py

You can test manually:

bash
Copy
Edit
python classify.py sample.jpg 0.6
========================================================
STEP 8: USING THE SYSTEM THROUGH THE WEB INTERFACE
Make sure:
[✔] Apache is running
[✔] MySQL is running
[✔] Model file is in pages/
[✔] classify.py is working
[✔] Python is in PATH

Open:
👉 http://localhost/beans-classifier/

Login (if login system is active)

Check the users table in phpMyAdmin for existing users

Or register if available

Go to the Scan page
👉 Upload a coffee bean image
👉 Adjust the confidence threshold slider
👉 Optionally crop the image
👉 Click Classify

Output:

Predicted label (Ripe, Underripe, etc.)

Grad-CAM heatmap

Confidence % per class

Record saved in the database

===========================================================
STEP 9: FILE STRUCTURE EXPLANATION
Folder/File	Description
index.php	Home page/login page
pages/scan.php	Image upload and classification UI
classify.py	Python backend classifier
pages/	Includes Grad-CAM logic, model, PHP UI
uploads/	Stores uploaded images temporarily
beans.sql	MySQL database with tables
connections.php	DB connection for PHP
beans_efffnetb3.keras	AI model file (place in pages/)

===========================================================
TROUBLESHOOTING
🛑 ERROR: "Could not run classifier"
✔️ Make sure Python is installed
✔️ Make sure you can run classify.py manually
✔️ Check if beans_efffnetb3.keras exists in pages/

🛑 Grad-CAM not appearing?
✔️ Ensure matplotlib is installed
✔️ Check write permissions for uploads/ folder

🛑 Model not loading?
✔️ Double-check filename: beans_efffnetb3.keras
✔️ Check TensorFlow version compatibility

===========================================================
OPTIONAL IMPROVEMENTS
Add user roles (Admin vs Staff)

Include charts or reports for classifications

Deploy the app online (using hosting or Docker)

Convert to offline PWA

Add multi-language support

===========================================================
CONTACT / SUPPORT
Project created by: xmikachu

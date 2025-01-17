## Description

This is a wordpress plugin that extends standard woocommerce import products functionality and lets you import, not only from a local file, but also from your google sheet file which you store on your google drive and can be edited by any member of your store team.

Standard woocommerce import, that was introduced by woocommerce team since version 3.1, became a greater plugin feature that lets you not use additional plugins and extensions for product import processes. However, if it’s a pain every time when you’re loading csv import files from your local machine, then woocommerce-import-products-google-sheet is a great choice that lets you not to do it anymore. Just set your google sheet name that you store on your google drive once and in the future you will only have to press the button "Import" as usual. Plugin itself will pull the new data from the specified google sheet table.

## Installation
1. Upload the plugin to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

## Set plugin option

After plugin installation we need to get client_secret json from google drive api.

Below are the instructions on how we can receive client_secret json.

1. Set your standard woocommerce import file to google drive.

2. Click link https://console.developers.google.com where you can find google console developer.

3. In the search input type "google drive" and click on the first tip "Google Drive API" ![](assets/images/readme_1.png)

4. If it is your first project in google developer console and you have never created a project before, then the system will ask you to create a new one, click button "Create" ![](assets/images/readme_2.png)

5. Then you will be redirected to the project settings page, for our needs, there will be enough standard project options and you can just click button "Create" on this page ![](assets/images/readme_3.png)

6. In the next page, the system will ask you to enable google drive api for your new project, then just press button "Enable" ![](assets/images/readme_4.png)

7. Then you will be redirected to the main google drive api info page where you can create new credentials if you have not created them before.  Just click button "Create Сredentials" ![](assets/images/readme_5.png)

8. In the next page, the system  will ask you to fill the form out with data for your credentials, please fill it in the same way as you can see on the screenshot below and press the button "What credentials do I need" ![](assets/images/readme_6.png)

9. In the next page you will see the next form for your credentials, feel free to choose any service account name in the appropriate field and select role project -> editor, key button type leave default json and press button "Continue" ![](assets/images/readme_7.png)

10. After that, the system will offer you to download the api key json file.  Save it on your local machine and then you can close google developer console browser tab.

11. Please copy the client_secret json key that you have received in the previous step to appropriate input in option plugin page ![](assets/images/readme_8.png)

12. Please find client_email in client_secret json and copy it to your buffer for the next step.

13. Open your google sheet file that you set to your google drive in step 1 and share access to it with client_email email that you copy to buffer in previous step ![](assets/images/readme_9.png)

14. Then copy the name of the google sheet file to appropriate plugin setting field "Google sheet title" and press the submit button. ![](assets/images/readme_10.png)

That’s all, if you set valid data you will see a success message, and when you next time try to import woocommerce product you will see an additional button that gives you the opportunity to import product from google sheet. ![](assets/images/readme_11.png)

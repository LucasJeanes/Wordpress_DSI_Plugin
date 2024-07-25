# Down Syndrome Ireland WordPress Plugins
These plugins were created to improve some of the technical features on the Down Syndrome Ireland (DSI) webpage. They can be easily imported into the DSI webpage by any member of staff, requiring very little technical knowledge. Here is a step-by-step guide to import these plugins into your project:

## Corporate Showcase Plugin

**1: Download the Plugin**
- Navigate to the DSI plugin repository or the provided download link.
- Download the plugin ZIP file to your computer.

**2: Log into the WordPress Admin Panel**
- Open your web browser and go to your WordPress admin login page.
- Enter your username and password to log in.
  
**3: Navigate to the Plugins Section**
- In the left-hand menu, click on "Plugins".
- Select "Add New" from the dropdown menu.
  
**4: Upload the Plugin**
- Click on the "Upload Plugin" button at the top of the page.
- Click "Choose File" and select the downloaded ZIP file of the plugin.
- Click "Install Now".
  
**5: Activate the Plugin**
- Once the installation is complete, click on the "Activate Plugin" button.
  
**6: Configure the Plugin**
- Navigate to the plugin settings page, which is found in the admin dashboard.
- These inputs are various things such as a corporate partner name, logo, description, and external link.

**7: Display Plugin on Page**
- To see the plugin working on a page, edit a page and input a shortcode box with the following code: "corporate_partners".
- Once this is completed publish the page and your page will display similarly to the following image.

![Corporate_Showcase](https://github.com/user-attachments/assets/ee971335-3afe-4aba-81e2-141701a32fdb)

## Donation Ticker Plugin

**Repeat steps 1-5 from the corporate showcase plugin instructions**

**6: Configure the Plugin**
- Navigate to the plugin settings page, which is found in the admin dashboard.
- Fill in the following information:
    - **Fundraiser Name**: Title of the fundraiser
    - **Target Amount**: Target financial goal for the fundraising event
    - **Database - Username**: Login username for database connection
    - **Database - Password**: Login password for database connection
    - **Database - Link Address**: URL endpoint for database eg. 192.168.0.1, 127.0.0.1, localhost
    - **Database - Donations Table Name**: Name of the table that stores the fundraiser donations
    - **Database - Donations Amount Column Name**: Name of the column in the fundraiser table which holds the numerical data to sum
    - **Database - Donations by filtered keyword**: If multiple fundraising event donations are stored in the same table, populate with a keyword to isolate. If empty, the donation ticker will sum up ALL donations in the table.
  ![image](https://github.com/user-attachments/assets/ec92cafd-a10f-496d-bc8e-63cfbf451815)
- Example database config:

![Untitled Diagram(3)](https://github.com/user-attachments/assets/c8279615-6e64-4275-be3c-a1c756719790)

**7: Display Plugin on Page**
- To see the plugin working on a page, edit a page and input a shortcode box with the following code: "donation_ticker".
- Once this is completed publish the page and your page will display similarly to the following image.


# TurkTrade_Website
This project is website of capstone project. Files uploaded here are website files. To see the running version of this project, please visit https://turktrade.ca. Please find login credentials below for testing user. Or you can create new user to test the project if you wish to.
# TEST LOGIN CREDENTIALS
Please visit https://my.turktrade.ca to login. Test user credentials are; <br/>
E-mail Address: test@test.net <br/>
Password: 999999 <br/>
<br/>
Note: There is credit card balance upload feature for this project. To create balance, visit accounts section from navbar and go to details of an account. You will see deposit funds section. Put the amount that textbox and 
credit card payment page will open. You will need to put testing credit card information. Real credit card information won't work as API keys are test keys. Testing credit card information are;<br/>
Visa: 4242 4242 4242 4242 - Any expiry date on future, and three digit cvv. <br/>
Visa (Debit): 4000 0566 5566 5556 - Any expiry date on future, and three digit cvv. <br/>
Mastercard: 5555 5555 5555 4444 - Any expiry date on future, and three digit cvv. <br/>
Amex: 3782 822463 10005 - Any expiry date on future, and four digit cvv. <br/>

# INFORMATION REGARDING API_KEYS, SENSITIVE INFORMATION AND INSTALLATION OF WEBSITE

* In my.turktrade.ca/dashboard/index.php file, line 1525, there is Stripe's test API key for processing credit card payments. I did not remove this API key as this key is test key and public key.<br/>
* In PHPMailer/MailSender.php file, line 38, I removed text MAIL_PASSWORD because it is personal mailbox password. SMTP information should be changed for mail sending function to work.<br/>
* In cronjob/pull_stock_data.php file, line 12 and line 15, I removed finnhub stock market API key. You will need to replace these keys with your own keys for stock market data pulling function to work.<br/>
* In cronjob/pull_stock_data.php file, line 11, database connection link should be replaced.<br/>
* In func/functions.php;<br/>
	* at line 16, I removed my yahoo stock market API provided by RAPIDAPI. This should be replaced for this function to work.<br/>
	* ALL 7 $con variables which contains PHP MySQLi database connection link, they need to be changed before installation. I removed database name,password and username from variables.<br/>
	* at line 70, I removed stripe payment processor's secret API key. This should be replaced.<br/>
* In config.php file, $con variable has database connection link. Database information should be replaced before installation.<br/>


# SQL DATABASE DUMP

I included TurkTrade Capstone Project's database file as .sql file. It is located at SQL/turktrade_data.sql file. This is the recent database structure I have and I may create new tables as I decide to implement new functionalities. This sql file only containts TurkTrade Capstone Project's structure. Data is not included.

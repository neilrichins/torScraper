Hello and thanks for using my torScraper code!
Be sure to give the project a star!


To run this code you will need PHP5-CLI , PHP5-CURL, TOR and TORSOCKS installed

From a Debian or Ubuntu based server:
        sudo apt-get update
        sudo apt-get install php5-cli php5-curl tor torsocks

Next check the torsocks config file for your TorSocksserver IP and port
        sudo nano /etc/torsocks

                server=127.0.0.1
                serverport=9050

Then create a password hash for tor
        tor --hash-password MySecretPassword

Tor will create a hashed password like this
        16:B3F112E483772429608B2B515824CA6C549709FA94F2CBDB3F29BDD93F

Edit the Tor config file, set the hashed password and Control Port
        sudo nano /etc/tor/torrc

              HashedControlPassword 16:B3F112E483772429608B2B515824CA6C549709FA94F2CBDB3F29BDD93F
              ControlPort 9051

Now update tortest.php with your Control Password and tor server details and execute tortest.php
        php tortest.php

If everything is setup correctly you should see two random IPs from the Tor network

Array
(
    [0] => 195.154.56.44

)
Array
(
    [0] => 198.50.145.72

)


Now edit tortest.php to change the website to search and what tags you want to scrape between for your data!

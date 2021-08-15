# Tekbase WHMCS Module

[![DeinServerHost.de](https://backup.mirror3.deinserverhost.icu/Partner/white.svg)](https://deinserverhost.de)
  
   
## Summary
A Module to create TekBase Licenses directly with your WHMCS Installation. No longer required to managed your Licenses through the Tekbase Admin Area, just setup a product and some configuration options and licenses can created fully automated. 

You can create, suspend, unsuspend, terminate and upgrade a license with this module.

![Tekbase Module Admin Area](https://img.dsh.gg/DSH-GW02-HGQjTeNmfZ-15-08-2021-12-01PM.png)

![Tekbase Module Clientarea](https://img.dsh.gg/DSH-GW02-QvG6R6i6M8-15-08-2021-04-26PM.png)
*Clientarea Template is just a Example, please create your own Template*
#



## Setup

To use this module you need to Download the current Release. Extract this file in your WHMCS Root directory.
All files should now in the right place.

This module requires a Server to run (not a real server) because we need to set our Reseller ID and our API Key. 
Login to your WHMCS Installation. Go to your Server Configuration

![Server Configuration](https://img.dsh.gg/DSH-GW02-kzJ35JQRKL-15-08-2021-04-31PM.png)

Add a new Server, as Module set Tebkase Reseller Module, Hostname or IP Address can be anything, because we don't need it. 
Username and Password is required. Username should be your Reseller ID and password your Reseller Key.

![Reseller Informations](https://img.dsh.gg/DSH-GW02-dRcTZSWfRI-15-08-2021-04-36PM.png)

If we're done fill all the fields, we test the connection with the button "Test Conection". 
The Test should be successful.   
      
![Test Successful](https://img.dsh.gg/DSH-GW02-hCctVuvjkO-15-08-2021-04-46PM.png)

Finally we need to set a name for this Server. 
You can choose what you want. After saving it, we need to add this server to an group.
I named the group Tekbase as like the server. 
![Server group](https://img.dsh.gg/DSH-GW02-8KD5sLSc3G-15-08-2021-04-48PM.png) 

Now we're done and we can start configure our Product(s) for it. Create a new Product and define these Configurationoptions:

If you want your customer to fully configured it, define each option:

![Configurationoptions](https://img.dsh.gg/DSH-GW02-vZYvi1NMsH-15-08-2021-04-50PM.png)

>Hint: If you define the Option name like gwislots|Gameserver it means, internally the field is named gwislots and for your customers its called Gameserver. That's the way you can define more understandable names.

The options for gwislots,rwislots,vwislots and swislots are:
``0``,``10``,``20``,``50``,``100``,``200``,``500`` and ``999999``

The options for Lizenz Typ ( version ) are: ``private``, ``std`` and ``adv``.  
``privat`` = A private license   
``std`` = A business license  
``adv`` = A business license with billing

>Also for those option you can use the same naming method to set internal the correct values and set a different name for your customers.
#

# Documentation 
### A more detailed documentation is coming soon.

#


## Copyright 2021 Thomas Brinkmann | DeinServerHost.de 
  
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

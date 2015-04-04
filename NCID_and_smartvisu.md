How to install and use NCID in smartvisu.

# Introduction #
For this phone service you need the SVN version of smartVisu ([revision 542](https://code.google.com/p/smartvisu/source/detail?r=542)).
You also need to install the NCID package on a server (same as smartvisu) and a compatible hardware like USB modem (see http://ncid.sourceforge.net/doc/NCID_Documentation.html#devices_top for informations).
You can find the package files directly on the web site of NCID http://sourceforge.net/projects/ncid/files/ncid/.

# NCIDD Details #
You need to install the NCIDD (NCID daemon) from packages or from sources. You can also install clients parts if you want.
You must configure the ncidd part to have access to the hardware (see the documentation for specific hardware), and to send the list of all received calls when a client established a connection.
Edit the /etc/ncid/ncidd.conf file :
```
send cidlog
```
Restart the service.

You can test the connection to the server with tools like netcat.
```
nc <ipserver> 3333
```
or ncid client
```
ncid --no-gui <ipserver> 3333
```


# smartvisu Details #

Go to the smarVisu configuration page. Select the NCID system on phone part.
Put the IP address of your server and the NCIDD tcp port (3333 by default).
You don't need to have username and password informations.
Save the configuration.

# Page Details #

Now you can use a simple page to list incoming calls.

```
{% extends "rooms.html" %}
{% import "phone.html" as phone %}

{% block content %}
    
   <div class="block">
        <div class="ui-bar-c ui-li-divider ui-corner-top">Calls</div>
        <div class="ui-fixed ui-body-a ui-corner-bottom">
		{{ phone.list('phonelist', '') }} 
	</div>
   </div>
{% endblock %}

```

# Limitations #

NCID is not a IP phone solution. So you don't have the outgoing calls because the modem is not used to call. The phone.missedlist will never display calls.
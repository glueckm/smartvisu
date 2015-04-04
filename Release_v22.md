# What is new in release v2.2? #

This release is for all that have '[smarthome.py](http://mknx.github.com/smarthome/)' or '[DomotiGa](http://www.domotiga.nl/)'.
Both work with a websockets for realtime communication without any delays. Mention that not all browsers support websockets!

Beside that we have made many improvements:
  * New model-homes
  * New design: 'Greenhornet'
  * New phone-service: fritz!box 5.5
  * New event and notification center
  * New language: dutch
  * New icons: all named in english (thanks to mfd)



## Driver: smarthome.py ##

If you are going to use this driver all items should be divided with a '.' point. They have to be in the structure defined in your smarthome.py config like:
```
floor.room.light.value
```

Set the address (in the config) to the server-ip (or dns). Do not use 'localhost', because the ip has to be reached from the client.
The standard-port is 2424.


## Model-home: Otterstaetter ##

<img src='http://smartvisu.googlecode.com/svn/wiki/v2.2/tb_otterstaetter.jpg' title='model-home: Otterstaetter' width='800'>


<h2>Model-home: Meister</h2>

<img src='http://smartvisu.googlecode.com/svn/wiki/v2.2/tb_meister.jpg' title='model-home: Meister' width='800'>


<h2>Event and Notification Center</h2>

A notification might be: an info, an 'ok' or an 'error'. All drivers or services display there messages with the notification-center.<br>
<br>
<img src='http://smartvisu.googlecode.com/svn/wiki/v2.2/mo_event_error.jpg' title='notify: an error' width='300'>


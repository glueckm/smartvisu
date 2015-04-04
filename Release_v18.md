# What is new in release v1.8? #

The focus in this relase was on connection to some phone systems. Two systems are supportet now: Auerswald and fritz!box.

Two new widgets (located in 'widgets/phone.html') come to show the caller-lists.

## phone.missedlist ##
for calls witch are not ansered. You may place this list on your startscreen.

<img src='http://smartvisu.googlecode.com/svn/wiki/v1.8/tb_startscreen.jpg' title='widget: phone.missedlist on startscreen' width='600'>

<h2>phone.list</h2>
for all incoming and outgoing calls<br>
<br>
<img src='http://smartvisu.googlecode.com/svn/wiki/v1.8/wt_phone.list.jpg' title='widget: phone.list' width='400'>


<h1>Details</h1>
The phone widgets must be configured through the config-page. You choose your phone system with a dropdown. Phone systems from Auerswald (such as VoiP 5010, VoiP 5020 or Commander Basic.2) need a user and a password. Best practice is to create a new user in the phone system and use these. The fritz!box (such as fritz!box 7050) use only a password, user can be left empty. The 'offline' phone system ist only for demo and creates random values.<br>
<br>
If you wan't to extend smartVISU to your phone system, place you have to create a new file in 'lib/phone/service' named as your phone system. Show at the files located there, to see how it will work.
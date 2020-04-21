![OpenTok](https://raw.githubusercontent.com/opentok/learning-opentok-php/master/tokbox-logo.png)
# Tokbox
[Opentok Packagist Link](https://packagist.org/packages/opentok/opentok)

[Opentok PHP SDK Reference](https://tokbox.com/developer/sdks/php/reference/namespaces/OpenTok.html)

## Composer Installation
```json
"opentok/opentok" : 4.4.x
```

## Session ID
Each client that connects to the session needs the session ID.
Generate new session IDs for new groups of clients.

## Archiving
OpenTok archiving feature to record the session.
It will use the OpenTok Media Router

## Token
Each client is issued a unique token, which grants them access to the session.

## API key
Identifies your OpenTok developer account.

## PHP Usage

### Initializing
```php
use OpenTok\OpenTok;

$opentok = new OpenTok($apiKey, $apiSecret);
```

### Creating Sessions
```php
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;

// An automatically archived session:
$sessionOptions = array(
    'archiveMode' => ArchiveMode::ALWAYS, // Setting whether the session will use the OpenTok Media Router or attempt to send streams directly between clients.
    'mediaMode' => MediaMode::ROUTED, // A session that uses the OpenTok Media Router, which is required for archiving
    'location' => '12.34.56.78' // Specifying a location hint
);

// Create a session that attempts to use peer-to-peer streaming:
$session = $opentok->createSession($sessionOptions);

// Store this sessionId in the database for later use
$sessionId = $session->getSessionId();
```

### Generating Tokens
```php
use OpenTok\Session;
use OpenTok\Role;

// Generate a Token from just a sessionId (fetched from a database)
$token = $opentok->generateToken($sessionId, array());

// Generate a Token by calling the method on the Session (returned from createSession)
$token = $session->generateToken();

const (
    Days30  = 2592000 //30 * 24 * 60 * 60
    Weeks1  = 604800  //7 * 24 * 60 * 60
    Hours24 = 86400   //24 * 60 * 60
    Hours2  = 7200    //60 * 60 * 2
    Hours1  = 3600    //60 * 60
)

// Set some options in a token
$token = $session->generateToken(array(
    'role'       => Role::MODERATOR,
    'expireTime' => time()+(7 * 24 * 60 * 60), // in one week
    'data'       => 'name=Johnny',
    'initialLayoutClassList' => array('focus')
));
```

### Working with Streams
Get information about a stream
```php
// Get stream info from just a sessionId (fetched from a database)
$stream = $opentok->getStream($sessionId, $streamId);

// Stream properties
$stream->id; // string with the stream ID
$stream->videoType; // string with the video type
$stream->name; // string with the name
$stream->layoutClassList; // array with the layout class list
```

Get information about all the streams in a session
```php
// Get list of streams from just a sessionId (fetched from a database)
$streamList = $opentok->listStreams($sessionId);

$streamList->totalCount(); // total count
```

### Working with Archives
```php
// Create a simple archive of a session
$archive = $opentok->startArchive($sessionId);

// Create an archive using custom options
$archiveOptions = array(
    'name' => 'Important Presentation',     // default: null
    'hasAudio' => true,                     // default: true
    'hasVideo' => true,                     // default: true
    'outputMode' => OutputMode::COMPOSED,   // default: OutputMode::COMPOSED (OutputMode::INDIVIDUAL - each stream in the archive to be recorded to its own individual file)
    'resolution' => '1280x720'              // default: '640x480'
);
$archive = $opentok->startArchive($sessionId, $archiveOptions);

// Store this archiveId in the database for later use
$archiveId = $archive->id;

// Stop an Archive from an archiveId (fetched from database)
$opentok->stopArchive($archiveId);
// Stop an Archive from an Archive instance (returned from startArchive)
$archive->stop();

// download the Archive
$archive = $opentok->getArchive($archiveId);
$archive->toJson(); // Get archive information
if ($archive->status=='available') { // View an Archive
    return redirect($archive->url);
}

// Delete an Archive from an archiveId (fetched from database)
$opentok->deleteArchive($archiveId);
// Delete an Archive from an Archive instance (returned from startArchive, getArchive)
$archive->delete();

// paginate list archive
$page = intval($request->get('page'));
if (empty($page)) $page = 1;
$offset = ($page - 1) * 5;

$archives = $opentok->listArchives($offset, 5); // list of all the Archive by $opentok->listArchives();
$toArray = $archives->toArray();

// Get an array of OpenTok\Archive instances
$getItems = $archives->getItems();

// Get the total number of Archives for this API Key
$totalCount = $archives->totalCount();

// example
return view('history.html', [
    'archives' => array_map($toArray, $getItems),
    'showPrevious' => $page > 1 ? '/history?page='.($page-1) : null,
    'showNext' => $totalCount() > $offset + 5 ? '/history?page='.($page+1) : null
]);
GET /archive // fetch up to 1000 archive objects
GET /archive?count=10  // fetch the first 10 archive objects
GET /archive?offset=10  // fetch archives but first 10 archive objetcs
GET /archive?count=10&offset=10 // fetch 10 archive objects starting from 11st

// change the layout dynamically
$layout Layout::getPIP(); // Or use another get method of the Layout class.
$opentok->updateArchiveLayout($archiveId, $layout);
```

### You can set change the layout dynamically
```php
$layout Layout::getPIP(); // Or use another get method of the Layout class.
$opentok->updateBroadcastLayout($broadcastId, $layout);
```
You can use the Layout class to set the layout types: Layout::getHorizontalPresentation(), Layout::getVerticalPresentation(), Layout::getPIP(), Layout::getBestFit(), Layout::createCustom()
```php
$layoutType = Layout::getHorizontalPresentation();
$opentok->setArchiveLayout($archiveId, $layoutType);

// For custom Layouts, you can do the following
$options = array(
    'stylesheet' => 'stream.instructor {position: absolute; width: 100%;  height:50%;}'
);

$layoutType = Layout::createCustom($options);
$opentok->setArchiveLayout($archiveId, $layoutType);
```

### Working with Broadcasts
You can only start live streaming broadcasts for sessions that use the OpenTok Media Router.
```php
// Start a live streaming broadcast of a session
$broadcast = $opentok->startBroadcast($sessionId);

// Start a live streaming broadcast of a session, using broadcast options
$options = array(
    'layout' => Layout::getBestFit(),
    'maxDuration' => 5400,
    'resolution' => '1280x720'
);
$broadcast = $opentok->startBroadcast($sessionId, $options);

// Store the broadcast ID in the database for later use
$broadcastId = $broadcast->id;

// To get an OpenTok\Broadcast instance from a broadcast ID
$broadcast = $opentok->getBroadcast($broadcastId);

// Stop a broadcast from an broadcast ID (fetched from database)
$opentok->stopBroadcast($broadcastId);

// Stop a broadcast from an Broadcast instance (returned from startBroadcast)
$broadcast->stop();
```

### Force a Client to Disconnect
Your application server can disconnect a client from an OpenTok session.
```php
// Force disconnect a client connection
$opentok->forceDisconnect($sessionId, $connectionId);
```

### Sending Signals
Once a Session is created, you can send signals to everyone in the session or to a specific connection.

The `$connectionId` parameter is an optional string used to specify the connection ID of a client connected to the session. If you specify this value, the signal is sent to the specified client. Otherwise, the signal is sent to all clients connected to the session.
```php
use OpenTok\OpenTok;

// Send a signal to a specific client
$signalPayload = array(
    'data' => 'some signal message',
    'type' => 'signal type'
);
$connectionId = 'da9cb410-e29b-4c2d-ab9e-fe65bf83fcaf'; // optional - signal send to particular client
$opentok->signal($sessionId, $signalPayload, $connectionId);

// Send a signal to everyone in the session
$signalPayload = array(
    'data' => 'some signal message',
    'type' => 'signal type'
);
$opentok->signal($sessionId, $signalPayload);
```

### Working with SIP Interconnect
You can add an audio-only stream from an external third-party SIP gateway using the SIP Interconnect feature.
```php
SIP_URI=sip:
SIP_USERNAME=
SIP_PASSWORD=
SIP_SECURE=false
SIP_FROM=003456@yourcompany.com

$sipUri = 'sip:user@sip.partner.com;transport=tls';

$options = array(
	'headers' =>  array(
		'X-CUSTOM-HEADER' => 'headerValue'
	),
	'auth' => array(
		'username' => 'username',
		'password' => 'password'
	),
	'secure' => true,
	'from' => 'from@example.com'
);

$opentok->dial($sessionId, $token, $sipUri, $options);
```

## JS Usage

```js
$(document).ready(function() {
	var SAMPLE_SERVER_BASE_URL = 'http://localhost:8000';

	// Make an Ajax request to get the OpenTok API key, session ID, and token from the server
	$.get(SAMPLE_SERVER_BASE_URL + '/session', function(res) {
		apiKey = res.apiKey;
		sessionId = res.sessionId;
		token = res.token;

		initializeSession();
	});
});
```

### Sample HTML Page
```php
<html>
	<head>
	    <title> OpenTok Getting Started </title>
	    <script src="https://static.opentok.com/v2/js/opentok.js"></script>
	</head>
	<body>
	    <div>SessionKey: {{ $session_token }}</div>

	    <div id="videos">
	        <div id="subscriber"></div>
	        <div id="publisher"></div>
	    </div>

	    <script src="https://static.opentok.com/v2/js/opentok.min.js"></script>

	    <script type="text/javascript">
		    var token = '{{ $opentok_token }}';
		    var session_key = '{{ $session_token }}';
		    var api_key = '{{ $api_key }}';

		    // connect to open tok api using client side library
		    var session = OT.initSession(api_key, session_key);

		    // Subscribe to a newly created stream - when other user is connected we want to show them in subscriber div element
		    session.on('streamCreated', function(event) {
		        var subscriberOptions = {
		            insertMode: 'append',
		            width: '100%',
		            height: '100%'
		        };
		        session.subscribe(
		            event.stream, // The Stream object to which we are subscribing
		            'subscriber', // The target DOM element or ID (optional) for placement of the subscriber video
		            subscriberOptions, // (optional) that customize the appearance of the subscriber view
		            function(error) { // handler function (optional)
		                if (error) {
		                    console.log('There was an error publishing: ', error.name, error.message);
		                }
		            }
		        );
		    });

		    // Connecting to the session - when first user loads this page we want him to be shown in publisher div element
		    session.connect(token, function(error) {
		        if (!error) {
		            var publisherOptions = {
		                insertMode: 'append',
		                width: '100%',
		                height: '100%'
		            };
		            var publisher = OT.initPublisher(
		                'publisher', // The target DOM element or ID for placement of the publisher video
		                publisherOptions, // The properties of the publisher
		                function(error) {
		                    if (error) {
		                        console.log('There was an error initilizing the publisher: ', error.name, error.message);
		                        return;
		                    }
		                    // Once the Publisher object is initialized, we publish to the session
		                    session.publish(publisher, function(error) {
		                        if (error) {
		                            console.log('There was an error publishing: ', error.name, error.message);
		                        }
		                    });
		                }
		            );
		        } else {
		            console.log('There was an error connecting to the session:', error.name, error.message);
		        }
		    });

		    // When the client disconnects from the session
		    session.on('sessionDisconnected', function(event) {
		        console.log('You were disconnected from the session.', event.reason);
		    });
	    </script>
	</body>
</html>
```

### Recording the session to an archive
Ajax request send to server and the session ID of the session that needs to be recorded.

```js
// start recording button when clicked
function startArchive() {
	$.post(SAMPLE_SERVER_BASE_URL + '/start/' + sessionId);
	$('#start').hide();
	$('#stop').show();
}

// stop recording button when clicked
function stopArchive() {
	$.post(SAMPLE_SERVER_BASE_URL + '/stop/' + archiveID);
	$('#stop').hide();
	$('#start').show();
	$('#view').prop('disabled', false);
}
```

### Using the signaling API to implement text chat
A signal is sent using the signal() method of the Session object. To receive a signal a client needs to listen to the signal event dispatched by the session object.

```js
// when the user enters text in the input text field, the following code is executed:
form.addEventListener('submit', function(event) {
	event.preventDefault();

	// which sends a signal to all clients connected
	session.signal({
		type: 'msg',
		data: msgTxt.value
	}, function(error) {
		if (error) {
			console.log('Error sending signal:', error.name, error.message);
		} else {
			msgTxt.value = '';
		}
	});
});

// sends a message
session.on('signal:msg', function(event) {
	var msg = document.createElement('p');
	msg.innerText = event.data;
	msg.className = event.from.connectionId === session.connection.connectionId ? 'mine' : 'theirs';
	msgHistory.appendChild(msg);
	msg.scrollIntoView();
});
```

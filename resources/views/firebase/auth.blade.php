<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
<script src="{{ mix('js/app.js') }}"></script>
    <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-messaging.js"></script>
    {{-- <script src="/firebase-messaging-sw.js"></script>
    --}}
    <script>
        // TODO: Replace the following with your app's Firebase project configuration
        const firebaseConfig = {
            apiKey: "{{ Config::get('firebase.apiKey') }}",
            authDomain: "{{ Config::get('firebase.authDomain') }}",
            databaseURL: "{{ Config::get('firebase.databaseURL') }}",
            projectId: "{{ Config::get('firebase.projectId') }}",
            storageBucket: "{{ Config::get('firebase.storageBucket') }}",
            messagingSenderId: "{{ Config::get('firebase.messagingSenderId') }}",
            appId: "{{ Config::get('firebase.appId') }}",
            measurementId: "{{ Config::get('firebase.measurementId') }}"
        };

        // Initialize Firebase with a "default" Firebase project
        var defaultProject = firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();
        messaging.getToken().then((currentToken) => {
            console.log(currentToken);
            $.ajax({
                type: "POST",
                url: "/api/admin/fcm",
                data: {
                  fcm_token: currentToken,
                },
                headers : {
                      'Authorization': 'Bearer ' + JSON.parse(localStorage.getItem('token'))
                    },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    alert("done");
                }
            });
        }).catch((err) => {
            console.log('An error occurred while retrieving token. ', err);
        });
        messaging.onMessage((payload) => {
            showNotification();
            console.log('Message received. ', payload);
        });

        function showNotification() {
            const notification = new Notification("New message Incoming", {
                body: 'Hi There.'
            });
        }

    </script>
</body>

</html>

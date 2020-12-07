<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-messaging.js"></script>
    {{-- <script src="/firebase-messaging-sw.js"></script> --}}
    <script>
        // TODO: Replace the following with your app's Firebase project configuration
        const firebaseConfig = {
            apiKey: "AIzaSyBDDi_ztvLL6fzDnrGLPZ6-tvgA-2u4cyg",
            authDomain: "real-time-notiy.firebaseapp.com",
            databaseURL: "https://real-time-notiy.firebaseio.com",
            projectId: "real-time-notiy",
            storageBucket: "real-time-notiy.appspot.com",
            messagingSenderId: "705458511115",
            appId: "1:705458511115:web:9f759467102566d3",
            measurementId: "G-1FQEZJVG7X"
        };

        // Initialize Firebase with a "default" Firebase project
        var defaultProject = firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();
        /////////////////////////////////////////////////////////////////////////////
        messaging.getToken().then((currentToken) => {
            console.log(currentToken);
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

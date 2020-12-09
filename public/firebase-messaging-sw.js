importScripts('https://www.gstatic.com/firebasejs/8.1.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.1.1/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in
// your app's Firebase config object.
// https://firebase.google.com/docs/web/setup#config-object
firebase.initializeApp({
  apiKey: "AIzaSyBDDi_ztvLL6fzDnrGLPZ6-tvgA-2u4cyg",
  authDomain: "real-time-notiy.firebaseapp.com",
  databaseURL: "https://real-time-notiy.firebaseio.com",
  projectId: "real-time-notiy",
  storageBucket: "real-time-notiy.appspot.com",
  messagingSenderId: "705458511115",
  appId: "1:705458511115:web:9f759467102566d3",
  measurementId: "G-1FQEZJVG7X"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

messaging.onBackgroundMessage(function (payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  const notificationTitle = 'Background Message Title';
  const notificationOptions = {
    body: 'Background Message body.',
    icon: '/firebase-logo.png'
  };
  self.registration.showNotification(notificationTitle,
    notificationOptions);
});
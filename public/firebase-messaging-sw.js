importScripts("https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js");
importScripts(
    "https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"
);

// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
firebase.initializeApp({
    apiKey: "AIzaSyB86lcBroscc6kvR4GnOsPbQgQk7e1B6aI",

    authDomain: "jm-act.firebaseapp.com",

    projectId: "jm-act",

    storageBucket: "jm-act.appspot.com",

    messagingSenderId: "438056594649",

    appId: "1:438056594649:web:ed98a89d39d196417ca2c8",

    measurementId: "G-RDYLHFVMXX",
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function (payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload
    );
    // Customize notification here
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "https://upload.wikimedia.org/wikipedia/commons/thumb/f/fe/Video-Game-Controller-Icon-IDV-green.svg/249px-Video-Game-Controller-Icon-IDV-green.svg.png", //your logo here
    };

    return self.registration.showNotification(
        notificationTitle,
        notificationOptions
    );
});

// // Import the functions you need from the SDKs you need
// import { initializeApp } from "firebase/app";
// import { getAnalytics } from "firebase/analytics";
// // TODO: Add SDKs for Firebase products that you want to use
// // https://firebase.google.com/docs/web/setup#available-libraries

// // Your web app's Firebase configuration
// // For Firebase JS SDK v7.20.0 and later, measurementId is optional
// const firebaseConfig = {
//   apiKey: "AIzaSyB86lcBroscc6kvR4GnOsPbQgQk7e1B6aI",
//   authDomain: "jm-act.firebaseapp.com",
//   projectId: "jm-act",
//   storageBucket: "jm-act.appspot.com",
//   messagingSenderId: "438056594649",
//   appId: "1:438056594649:web:525c58b6317ff99c7ca2c8",
//   measurementId: "G-X7XBX60S8G"
// };

// // Initialize Firebase
// const app = initializeApp(firebaseConfig);
// const analytics = getAnalytics(app);

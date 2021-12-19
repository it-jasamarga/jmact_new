<script src="https://www.gstatic.com/firebasejs/8.8.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.8.1/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.8.1/firebase-firestore.js"></script>

<script>
  $(document).ready(function(){
        const firebaseConfig = {
            apiKey: "AIzaSyB86lcBroscc6kvR4GnOsPbQgQk7e1B6aI",
            authDomain: "jm-act.firebaseapp.com",
            projectId: "jm-act",
            storageBucket: "jm-act.appspot.com",
            messagingSenderId: "438056594649",
            appId: "1:438056594649:web:cfd66d006f17a3f67ca2c8",
            measurementId: "G-B1SMLNPGW3"
        };

        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();
        const db = firebase.firestore();

        if('serviceWorker' in navigator) { 
            navigator.serviceWorker.register("{{asset('firebase-messaging-sw.js')}}").then(function(registration) {
                console.log("Service Worker Registered");
                messaging.useServiceWorker(registration);  
// CHECK AUTH
                messaging.requestPermission().then(function (data) {
                    return messaging.getToken()
                }).then(function(token) {
                    $.post('{{ route("users.device") }}', { _token: "{{ csrf_token() }}", device_id: token });
                }).catch(function (err) {
                    console.log("Unable to get permission to notify.", err);
                });
            });
        }

  });
</script>
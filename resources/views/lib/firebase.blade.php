<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-firestore.js"></script>

<script>
  $(document).ready(function(){
    window.just_logged_in = {{ Session::pull('adr:just-logged-in', false) ? 'true' : 'false'; }};
    window.skip_bell_voice = false;

    let adr = {
		speech: {
            initiated: false,
            ready: false,
			available: false,
			voices: [],
			language: -1,
            wts: null,
			wss: window.speechSynthesis,
			init: function(preferences = ['id-ID', 'in_ID']) {
                if (adr.speech.initiated) return;
				if (! (adr.speech.available = (typeof speechSynthesis !== 'undefined'))) {
					console.log('## speechSynthesis feature not available');
					return;
				}
				if (adr.speech.voices.length < 1) {
					let voices = speechSynthesis.getVoices();
					adr.speech.voices = voices;
					console.log('## Available Voice', {voices}, 'Preferences', {preferences});
					adr.speech.voices.forEach(function(value, index) {
						if (adr.speech.language < 0) preferences.forEach(function(lang) {
							if (value.lang == lang) {
								adr.speech.language = index;
								console.log('## Selected Voice', adr.speech.voices[adr.speech.language]);
							}
						})
					});
				}
                adr.speech.ready = (adr.speech.language != -1);
                adr.speech.initiated = true;
			},
            stop: function() {
                console.log('## Stop to speak');
                adr.speech.wss.cancel();
                adr.speech.wts = null;
            },
			speak: function(whattosay, func_onend = null) {
                if ((adr.speech.available) && (!adr.speech.ready)) {
                    console.log('## Speak on hold 1sec due un-ready engine');
                    setTimeout(function() { adr.speech.speak(whattosay); }, 1000);
                    return;
                }
                if (! adr.speech.initiated) {
                    console.log('## Speak on hold 1sec due un-initiated engine');
                    setTimeout(function() { adr.speech.speak(whattosay); }, 1000);
                    return;
                }
                if ((adr.speech.available) && (adr.speech.wts !== null)) {
                    console.log('## Speak on hold 1sec due engine is still speaking');
                    setTimeout(function() { adr.speech.speak(whattosay); }, 1000);
                    return;
                } else adr.speech.wts = whattosay;

                if (! adr.speech.available) {
                    bell.play();
                } else {
                    adr.speech.wss.cancel();

                    if (! just_logged_in) {
                        console.log('## Can only speak once, the rest is ring a bell');
                        bell.play();
                    } else {
                        let ssu = new SpeechSynthesisUtterance(whattosay);
                        ssu.voice = adr.speech.voices[adr.speech.language];
                        ssu.onend = function(event) {
                            adr.speech.wts = null;
                            console.log('## Stop speaking');
                            if (func_onend !== null) {
                                console.log('## Running function', {func_onend});
                                func_onend();
                            }
                        };

                        console.log('## Start speaking "'+whattosay+'"');
                        adr.speech.wss.speak(ssu);
                    }
                }
			}
		}
	}

@if (auth()->check())
	setTimeout(function() {
		adr.speech.init();
        if (just_logged_in) {
            let today = new Date();
            let jam = parseInt(today.getHours().toString().padStart(2, '0')+today.getMinutes().toString().padStart(2, '0'));
            let waktu = "";
            if ((jam>500) && (jam<1100))
                waktu = "selamat pagi";
            else if ((jam>1059) && (jam<1500))
                waktu = "selamat siang";
            else if ((jam>1459) && (jam<1800))
                waktu = "selamat sore";
            else
                waktu = "selamat malam";
			let kalimat = "Halo, "+waktu+" {{ auth()->user()->name ?? (auth()->user()->username ?? "") }}! Selamat datang kembali di aplikasi web J M A C T ! Apa kabarnya Anda hari ini?";
			if ((typeof unread_notification !== 'undefined') && (unread_notification>0))
                kalimat += " Anda memiliki "+unread_notification+" notifikasi yang belum dibaca.";
			// kalimat += " Selamat bekerja, jangan lupa berdoa, keluarga menanti di rumah !  ";
			adr.speech.speak(kalimat, () => { console.log('## Set just_logged_in to false'); just_logged_in = false; });
        }
	}, 3000);
@endif

        const firebaseConfig = {
            apiKey: "AIzaSyB86lcBroscc6kvR4GnOsPbQgQk7e1B6aI",
            authDomain: "jm-act.firebaseapp.com",
            projectId: "jm-act",
            storageBucket: "jm-act.appspot.com",
            messagingSenderId: "438056594649",
            appId: "1:438056594649:web:ed98a89d39d196417ca2c8",
            // measurementId: "G-RDYLHFVMXX"
        };

        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();
        const db = firebase.firestore();

        if('serviceWorker' in navigator) {
            navigator.serviceWorker.register("{{asset('firebase-messaging-sw.js')}}").then(function(registration) {

                messaging.useServiceWorker(registration);
// CHECK AUTH
                messaging.requestPermission().then(function (data) {
                    return messaging.getToken()
                }).then(function(token) {
                    let path = window.location.pathname;
                    let login = '/login';
                    let lastchars = path.substr(path.length - login.length);
                    if (lastchars == login) {
                        console.log('## Firebase Messaging: add Device Token information', {token});
                        $('<input name="device-token" type="hidden">').val(token).insertAfter('input[name="_token"]');
                    }
                }).catch(function (error) {
                    console.log('## Firebase Messaging: Error', {error})
                });
            });


// GET MESSAGE AND PUSH
            messaging.onMessage((payload) => {
              console.log('## Message received. ', {payload});
              // ...
                var notify;
                notify = new Notification(payload.notification.title,{
                    body: payload.notification.body,
                    icon: payload.notification.image,
                    tag: payload.data.type,
                    sound: "default"
                });

            });

            self.addEventListener('notificationClick', function(event) {
                console.log('check')
                // event.notification.close();
            });

// READ / SHOW NOTIF
            var userId = '{{ (\Auth::check()) ? auth()->user()->id : null }}';

            if(userId){
                var htmlNotif = ``;
                var dbFirestore = db.collection('notifications')
                .where('status','==','Unread')
                .where('user_id','==', parseInt(userId))
                .orderBy("created_at", "desc")
                // .limit(10)
                ;

                dbFirestore.onSnapshot(function(querySnapshot) {
                    var htmlNotif = ``;
                    let iNotif = 0;
                    let maxNotif = 3;
                    querySnapshot.forEach(function(doc) {
                        iNotif++;

                        if (iNotif <= maxNotif) htmlNotif += `
                            <div class="d-flex align-items-center mb-6">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-40 symbol-light-success mr-5">
                                    <span class="symbol-label">
                                        <span class="svg-icon svg-icon-lg svg-icon-success">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group-chat.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z" fill="#000000" />
                                                    <path d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z" fill="#000000" opacity="0.3" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Text-->
                                <div class="d-flex flex-column font-weight-bold">
                                    <a href="javascript:void(0)" data-target_type="${doc.data().target_type}" data-target_id="${doc.data().target_id}" data-id="${doc.id}" class="notifClick text-dark text-hover-primary mb-1 font-size-lg">${doc.data().title}</a>
                                    <span class="text-muted">${doc.data().message}</span>
                                </div>
                                <!--end::Text-->
                            </div>
                        `;
                    });

                    var notifLength = querySnapshot.docs.length;
                    console.log('notifLength',notifLength)

                    window.unread_notification = notifLength;

                    if(notifLength > 0){
                        $('.pulse-check').removeClass('pulse-primary');
                        $('.pulse-check').addClass('pulse-danger');

                        $('.svg-check').removeClass('svg-icon-primary');
                        $('.svg-check').addClass('svg-icon-danger');

                        if (! just_logged_in) {
                            if (skip_bell_voice) {
                                skip_bell_voice = false;
                                console.log('## Bell voice skipped');
                            } else {
                                let kalimat = "Halo {{ auth()->user()->name ?? (auth()->user()->username ?? "") }}!";
                                if (typeof unread_notification !== 'undefined')
                                    kalimat += " Anda memiliki "+unread_notification+" notifikasi yang belum dibaca.";
                                adr.speech.speak(kalimat);
                            }
                        }
                        
                    }else{
                        $('.pulse-check').removeClass('pulse-danger');
                        $('.pulse-check').addClass('pulse-primary');

                        $('.svg-check').removeClass('svg-icon-danger');
                        $('.svg-check').addClass('svg-icon-primary');
                    }

                    $('.totalNotif').text(notifLength+' New');
                    $('.appendCount').text(notifLength)
                    $('.addHeader').html(htmlNotif);
                });
            }

            $(document).on('click','.notifClick',function(){
                let id = $(this).data('id');
                let t_id = $(this).data('target_id');
                let t_type = $(this).data('target_type');
                let url = (t_type == 'ClaimPelanggan' ? "{{ url('claim/') }}" : "{{ url('keluhan/') }}") +'/'+ t_id;
                // var id = $(this).data('id');
                // var url = "{{ url('/') }}" + $(this).data('url');
                var pathParent = null;
                skip_bell_voice = true;
                adr.speech.stop();
                db.collection("notifications").doc(id).update({
                    'status':'Read'
                }).then(function(){
                    window.location = url;
                });
            });

        }


  });
</script>

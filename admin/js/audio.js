	/*
	$(document).on('click', '*', function() {
		// prepoznavanje glasa
		if (window.hasOwnProperty('webkitSpeechRecognition')) {
			var recognition = new webkitSpeechRecognition();
			recognition.continuous = false;
			recognition.interimResults = false;
			recognition.lang = "sr-RS";
			recognition.start();
			recognition.onresult = function(e) {
				var word=e.results[0][0].transcript;
				recognition.stop();	
				// dogadjaji na klik
				$('#side-menu a, .nav-label, tbody a, .dt-buttons a, .html5buttons a, .pagination a, thead a').each(function() {
				var str = $(this).text();
				if (str.toUpperCase()==word.toUpperCase()) {
					$(this).focus();
					$(this).trigger("click");
				}
			});
			}
		}
	});			*/

	function audio_recording() {	
		$("input.write_title, input.write_content").click(function() {
			$(this).val('true');
		});	
		$('#start-recording-title, #start-recording-content').on('click',  function() {
			window.field_name = $(this).parent().parent().attr('id'); 	
			$(this).toggleClass('btn-default').toggleClass('btn-primary');
			if (window.field_name=='audio_content') $('#stop-recording-content').toggleClass('btn-primary').toggleClass('btn-default');
			else $('#stop-recording-title').toggleClass('btn-primary').toggleClass('btn-default');
			navigator.mediaDevices.getUserMedia({audio: true}).then(onMediaSuccess).catch(onMediaError);	
			if (window.field_name=='audio_content') var write =$("input.write_content").val();
			else var write =$("input.write_title").val();
			if (write=='true')
			{	
				window.recognition = new webkitSpeechRecognition();
				window.recognition.continuous = true;
				window.recognition.interimResults = false;
				window.recognition.lang = "sr-RS";
				window.rec_cont =true;
				window.speech="";
				write_speech();
				function write_speech()
				{
					window.recognition.start();
					window.recognition.onresult = function(e) {
						window.speech=window.speech+e.results[0][0].transcript;
						if (window.field_name=='audio_content') {
							CKEDITOR.instances[ 'rtel' ].destroy(true);
							$('#inner #rtel').text(window.speech);
							CKEDITOR.replace( 'rtel', { height:'100', width:'650'});					
						}	
						else $('#inner #title').val(window.speech);	
						
					};
				}
			}
		});
	   $('#stop-recording-title, #stop-recording-content').on('click',  function() {
			window.rec_cont=false;
			$(this).toggleClass('btn-default').toggleClass('btn-primary');		   
			if (window.field_name=='audio_content') $('#start-recording-content').toggleClass('btn-primary').toggleClass('btn-default');
			else $('#start-recording-title').toggleClass('btn-primary').toggleClass('btn-default');		   
			mediaRecorder.stream.stop();			
			mediaRecorder.stop();	
			//window.recognition.stop();	
		});				
	}

		
	var mediaRecorder;
	
	function onMediaSuccess(stream) {
		mediaRecorder = new MediaStreamRecorder(stream);
		mediaRecorder.stream = stream;
		mediaRecorder.recorderType = StereoAudioRecorder; //		MediaRecorderWrapper	
		mediaRecorder.mimeType = 'audio/wav'; // audio/ogg or audio/wav or audio/webm
		mediaRecorder.audioChannels = 1; //2
		mediaRecorder.ondataavailable = function(blob) {
			// upload each blob to PHP server
			uploadToPHPServer(blob);
		};	
		mediaRecorder.start(60000);

	}
	function onMediaError(e) {
		console.error('media error', e);
	}
	
	function uploadToPHPServer(blob) {
		var file = new File([blob], 'audio_file-' + (new Date).toISOString().replace(/:|\./g, '-') + '.webm', {
			type: 'audio/wav'
		});
		// create FormData
		var formData = new FormData();
	
		formData.append('audio-class', window.class1);
		var id='#inner #'+ window.class1 + '_id';
		formData.append('audio-id', $(id).val());
		var field_name=window.field_name;		
		formData.append('audio-field_name', window.field_name);
		formData.append('audio-filename', file.name);
		formData.append('audio-blob', file);
		makeXMLHttpRequest('audio_save.php', formData);
		window.fn = (file.name);
	}

	function makeXMLHttpRequest(url, data, callback) {
		var request = new XMLHttpRequest();
		request.onreadystatechange = function() {
			if (request.readyState == 4 && request.status == 200) {
				
				var fn = "../audio_content/"+window.fn;
				if (window.field_name=='audio_content')
				{	
					$("#audio_content audio source").attr('src',fn);
					$("#audio_content audio")[0].load();
				}
				else
				{
					$("#title audio source").attr('src',fn);	
					$("#title audio")[0].load();
				}	
			}
		};
		request.open('POST', url);
		request.send(data);
	}			

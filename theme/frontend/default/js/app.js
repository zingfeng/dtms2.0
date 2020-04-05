//webkitURL is deprecated but nevertheless
URL = window.URL || window.webkitURL;

var gumStream; 						//stream from getUserMedia()
var rec; 							//Recorder.js object
var input; 							//MediaStreamAudioSourceNode we'll be recording

var interval_timer;

// shim for AudioContext when it's not avb. 
var AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext ;//audio context to help us record

var recordButton = document.getElementById("recordButton");
var stopButton = document.getElementById("stopButton");
var pauseButton = document.getElementById("pauseButton");


//add events to those 2 buttons

if (typeof(recordButton) != 'undefined' && recordButton != null) {
	recordButton.addEventListener("click", startRecording);
}

if (typeof(stopButton) != 'undefined' && stopButton != null){
	stopButton.addEventListener("click", stopRecording);
}

if (typeof(pauseButton) != 'undefined' && pauseButton != null){
	pauseButton.addEventListener("click", pauseRecording);
}

function startRecording() {
	console.log("recordButton clicked");

	/*
		Simple constraints object, for more advanced audio features see
		https://addpipe.com/blog/audio-constraints-getusermedia/
	*/
    
    var constraints = { audio: true, video:false }

 	/*
    	Disable the record button until we get a success or fail from getUserMedia() 
	*/

	recordButton.disabled = true;
	stopButton.disabled = false;
	pauseButton.disabled = false

	/*
    	We're using the standard promise based getUserMedia() 
    	https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia
	*/

	navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
		console.log("getUserMedia() success, stream created, initializing Recorder.js ...");

		/*
			create an audio context after getUserMedia is called
			sampleRate might change after getUserMedia is called, like it does on macOS when recording through AirPods
			the sampleRate defaults to the one set in your OS for your playback device

		*/
		audioContext = new AudioContext();

		//update the format 
		document.getElementById("formats").innerHTML="Format: 1 channel pcm @ "+audioContext.sampleRate/1000+"kHz"

		/*  assign to gumStream for later use  */
		gumStream = stream;
		
		/* use the stream */
		input = audioContext.createMediaStreamSource(stream);

		/* 
			Create the Recorder object and configure to record mono sound (1 channel)
			Recording 2 channels  will double the file size
		*/
		rec = new Recorder(input,{numChannels:1})

		//start the recording process
		rec.record();

		console.log("Recording started");

	}).catch(function(err) {
	  	//enable the record button if getUserMedia() fails
    	recordButton.disabled = false;
    	stopButton.disabled = true;
    	pauseButton.disabled = true
	});
}

function pauseRecording(){
	console.log("pauseButton clicked rec.recording=",rec.recording );
	if (rec.recording){
		//pause
		rec.stop();
		pauseButton.innerHTML="Resume";
	}else{
		//resume
		rec.record()
		pauseButton.innerHTML="Pause";

	}
}

function stopRecording() {
	console.log("stopButton clicked");

	//disable the stop button, enable the record too allow for new recordings
	stopButton.disabled = true;
	recordButton.disabled = false;
	pauseButton.disabled = true;

	//reset button just in case the recording is stopped while paused
	//reset button just in case the recording is stopped while paused
	pauseButton.innerHTML="Pause";
	
	//tell the recorder to stop the recording
	rec.stop();

	//stop microphone access
	gumStream.getAudioTracks()[0].stop();

	//create the wav blob and pass it on to createDownloadLink
	rec.exportWAV(createDownloadLink);

	clearInterval(interval_timer);
}

function setTimeCurrent() {
	var time =  Math.round(rec.context.currentTime); // Second
	var second = time % 60;
	var min = (time-second)/60;

	second = convert2number(second);
	min = convert2number(min);
	return min + ':' + second;
}

function convert2number(number){
	if (number <10){
		return '0'+number;
	}
	return number
}

function createDownloadLink(blob) {
	var url = URL.createObjectURL(blob);
	var au = document.createElement('audio');
	var li = document.createElement('li');
	li.style.listStyle = 'none';
	var link = document.createElement('a');

	//name of .wav file to use during upload and download (without extendion)
	var id_question = getStatus();
	var filename = new Date().toISOString();

	//add controls to the <audio> element
	au.controls = true;
	au.src = url;

	//save to disk link
	link.href = url;
	link.style.display = 'none';
	link.download = id_question + filename+".wav"; //download forces the browser to donwload the file using the  filename
	link.innerHTML = "Save to disk";

	//add the new audio element to li
	li.appendChild(au);
	
	//add the filename to the li
	// li.appendChild(document.createTextNode(filename+".wav "))

	//add the save to disk link to li
	li.appendChild(link);
	
	//upload link
	var upload = document.createElement('a');
	upload.href="javascript:void(0);";
	upload.style.display = 'none';
	upload.innerHTML = "Upload";
	upload.addEventListener("click", function(event){

			var fd = new FormData();
			fd.append('fname', 'test.wav');
			fd.append('blob_file', blob);
			imUploading();
			$.ajax({
				type: 'POST',
				url: 'https://www.aland.edu.vn/users/upload_Mp3',
				data: fd,
				processData: false,
				contentType: false
			}).done(function(data) {
				try{
					var data_live = JSON.parse(data);
					console.log("data_live");
					console.log(data_live);
					var full_path = data_live[0];
					$('#recordingList' + id_question).attr('file_url',full_path);
				}catch (e) {

				}
				imUploadDone();
			});
	});


	li.appendChild(document.createTextNode (" "))//add a space in between
	li.appendChild(upload);//add the upload link to li

	//add the li element to the ol
	// recordingList.appendChild(li);

	// console.log("'recordingList' + id_question");
	// console.log('recordingList' + id_question);

	document.getElementById('recordingList' + id_question).appendChild(li);
	// change border color
	document.getElementById('recordingList' + id_question).style.borderLeft = '5px solid #f24962';

	setStatus('ready');
	upload.click(); // upload ngay
}

function imUploading() {

	$('#button_submit_show').attr('disabled',true);
	localStorage.setItem('upload','doing');
}
function imUploadDone() {
	$('#button_submit_show').attr('disabled',false);
	localStorage.setItem('upload','done');
}

function Click_Record_Client(id_question) {
	// id_recording Pause Finish
	// Finish
	var status = getStatus();


	if (status === 'ready'){
		console.log("id_question");
		console.log(id_question);

		setStatus(id_question);
		// setup text, color
		console.log("#img_speaking'+ id_question");
		console.log('#img_speaking'+ id_question);

		$('#img_speaking'+ id_question).attr('src','theme/frontend/default/images/icons/speaking1.png');

		recordButton.click();

		interval_timer = setInterval(function(){
			var time = setTimeCurrent();
			$('#span_speaking'+ id_question).html(time);
		}, 1000);
		showPause(id_question);
		showFinish(id_question);
	}else{
		alert('Bạn cần hoàn thành bài ghi âm dở dang trước khi bắt đầu bài mới');
	}
}

function Click_Pause_Client(id_question) {

	var now_status_pause = $('#span_speaking_pause' + id_question).html();
	if (now_status_pause ==='Resume' ){
		$('#span_speaking_pause' + id_question).html('Pause');
		pauseRecording();

		interval_timer = setInterval(function(){
			var time = $('#span_speaking'+ id_question).html();

			var tim222 = time.substr(0,2);
			var time_min_int = parseInt(tim222);
			var tim333 = time.substr(3,2);
			var time_second_int = parseInt(tim333);
			var time_int = time_min_int*60 + time_second_int;
			time_int ++;

			var second = time_int % 60;
			var min = (time_int-second)/60;

			second = convert2number(second);
			min = convert2number(min);
			$('#span_speaking'+ id_question).html(min + ':' + second);
		}, 1000);

	}else{
		$('#span_speaking_pause' + id_question).html('Resume');
		pauseRecording();
		clearInterval(interval_timer);
	}

}

function Click_Finish_Client(id_question) {
	// id_recording Pause Finish
	// Finish
	clearInterval(interval_timer);
	stopRecording();
	showRecordAgain(id_question);
}

function showRecordAgain(id_question) {
	$('#a_speaking_record_again' + id_question).css('display','inline-block');
}

function Click_Record_Again(id_question){
	var file_url_old = $('#recordingList' + id_question).attr('file_url');
	// Xóa file trên Server
	$.post("https://www.aland.edu.vn/users/del_Mp3",
		{
			del_mp3: 'del_temp',
			file_name: file_url_old,
		},
		function (data, status) {
			console.log("data");
			console.log(data);
		});

	$('#a_speaking_record_again' + id_question).css('display','none');
	$('#span_speaking' + id_question).html('click để làm bài');
	$('#a_speaking' + id_question).click();
	$('#recordingList' + id_question).attr('file_url','');
	$('#recordingList' + id_question).html('');

	// Chuyển thông tin thẻ đầu tiên
}

function showPause(id_question) {
	$('#a_speaking_pause' + id_question).css('display','inline-block');
}

function showFinish(id_question){
	$('#a_speaking_finish' + id_question).css('display','inline-block');
}


function setStatus(status){
	localStorage.setItem('status_speaking',status);
}
function getStatus(){
	return localStorage.getItem('status_speaking');
}

// upload all mp3 file

function GetListMp3File(){
	var stt = localStorage.getItem('upload');
	if (stt !== 'done'){
		alert("There are some files uploading, wait 1 min then try again");
	}else{
		// Lấy chi tiết answer
		var arrAnswer = {};
		$(".recordingList").each(function () {
			var id = $(this).attr('id');
			var id_question = id.replace('recordingList','');
			var file_url = $(this).attr("file_url");
			console.log("id_answer");
			console.log(id_question);
			console.log("file_url");
			console.log(file_url);
			// arrAnswer.push([id_question,file_url]) ;
			arrAnswer[id_question] = file_url;
		});
		return arrAnswer;
	}
}

$(function(){
	setStatus('ready');

	$("a.icon_speaking_record").each(function () {

		$( this ).bind( "click", function() {
			var id_question = $(this).attr('id_question');
			Click_Record_Client(id_question);
		});
	});

	$("a.icon_speaking_pause").each(function () {
		$( this ).bind( "click", function() {
			var id_question = $(this).attr('id_question');
			Click_Pause_Client(id_question);
		});
	});

	$("a.icon_speaking_finish").each(function () {
		$( this ).bind( "click", function() {
			var id_question = $(this).attr('id_question');
			Click_Finish_Client(id_question);
			$('#a_speaking' + id_question).css('display','none');
			$('#a_speaking_pause' + id_question).css('display','none');
			$('#a_speaking_finish' + id_question).css('display','none');
		});
	});

	$("a.icon_speaking_record_again").each(function () {
		$( this ).bind( "click", function() {
			var id_question = $(this).attr('id_question');
			Click_Record_Again(id_question);
			$('#a_speaking' + id_question).css('display','inline-block');
			$('#a_speaking_pause' + id_question).css('display','inline-block');
			$('#a_speaking_finish' + id_question).css('display','inline-block');
		});
	});


	$("a.icon_speaking_part2").each(function () {
		$( this ).bind( "click", function() {
			var id_question = $(this).attr('id_question');
			$('#a_speaking' + id_question).css('display','none');
			$('#p_count_' + id_question).css('display','block');
		});
	});
});


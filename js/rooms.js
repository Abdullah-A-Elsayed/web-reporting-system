
function roomSelect(ev){
	var n = ev.target.value;
	var inner="";
	for (var i = 1; i <= n; i++) {
		inner+='<label class="col-md-12 control-label" >Room '+i+'</label><div class="col-md-12 inputGroupContainer"><div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input name="room'+i+'ID" placeholder="room ID" class="form-control"  type="text" required ></div></div>';
		inner+='<div class="col-md-12 inputGroupContainer"><div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><textarea name="room'+i+'comment" placeholder="room comment" class="form-control" required></textarea></div></div>';
		inner+='<br>';
	}
	document.getElementById('rooms').innerHTML=inner;
}

function visitSelect(ev){
	var n = ev.target.value;
	if(n==='yes'){
		document.getElementById('visits').style.display='block';
	}
	else if (n=='no') {
		document.getElementById('visits').style.display='none';
		document.getElementById('visits-comment').removeAttribute("required");
		document.getElementById('visits-sel').removeAttribute("required");
	}
}

function workshopSelect(ev){
	var n = ev.target.value;
	if(n==='yes'){
		document.getElementById('workshops').style.display='block';
	}
	else if (n=='no') {
		document.getElementById('workshops').style.display='none';
		document.getElementById('workshops-comment').removeAttribute("required");
	}
}
$(function(){
	var atmark = '@';
	$('#signup_form').submit(function() {
		var er = 0;
    var user = $('#user').val();
    var email = $('#e-mail').val();
		var password = $('#password').val();

		if(user == '') {
			$('#message0').text('ユーザー名を入力してください');
			er++;
		}else{
			$('#message0').text('');
		}

    if(email == '') {
      $('#message1').text('メールアドレスを入力してください');
			er++;
    }else if((email.indexOf(atmark) < 0) || (email.indexOf(atmark)==email.length-1)) {
			$('#message1').text('@以下を入力してください');
			er++;
    }else{
			$('#message1').text('');
		}

		if(password == '') {
			$('#message2').text('パスワードを入力してください');
			er++;
		}else if(password.length < 8) {
			$('#message2').text('8文字以上入力してください');
			er++;
		}else {
			$('#message2').text('');
		}
		if(er > 0) return false;
		else return true;
  });
	$('#login_form').submit(function() {
		var er = 0;
    var email = $('#e-mail').val();
		var password = $('#password').val();

		if(email == '') {
			$('#message1').text('メールアドレスを入力してください');
			er++;
		}else if((email.indexOf(atmark) < 0) || (email.indexOf(atmark)==email.length-1)) {
			$('#message1').text('@以下を入力してください');
			er++;
		} else{
			$('#message1').text('');
		}

		if(password == '') {
			$('#message2').text('パスワードを入力してください');
			er++;
		}else {
			$('#message2').text('');
		}
		if(er > 0) return false;
		else return true;
	});

	$('#post_form').submit(function() {
		var er = 0;
		var comment = $('#comment').val();
		if(comment == '') {
			$('#message1').text('コメントを入力してください');
			er++;
		}else if(comment.length > 140) {
			var com_len = comment.length;
			$('#message1').text('140字以下で入力してください（現在の文字数：'+com_len+'）');
			er++;
		} else{
			$('#message1').text('');
		}
		if(er > 0) return false;
		else return true;
	});
});

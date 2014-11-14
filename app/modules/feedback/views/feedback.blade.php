<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
		<p>
            Сообщение от: {{ $name }} <{{ $email }}>
            <br>Телефон: {{ $phone }}
            <hr/>
			{{ $content }}
            <hr/>
		</p>
	</div>
</body>
</html>
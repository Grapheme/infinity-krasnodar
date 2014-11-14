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
            <br>Название модели: {{ $product }}
            <hr/>
            {{ $content }}
		</p>
	</div>
</body>
</html>
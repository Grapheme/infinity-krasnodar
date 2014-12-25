<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
		<p>
			Посетитель, представившийся как {{ @$name }},<br>
			оставил заявку на тест-драйв {{ @$product }}.<br>
            {{ @$content }}<br>
            Контактные данные: {{ @$phone }}<br>
			<{{ @$email }}>
		</p>
	</div>
</body>
</html>
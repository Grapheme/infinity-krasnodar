<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
		<p>
            Посетитель, представившийся как {{ @$name }}, оставил заявку на заказ запчастей.<br>
            {{ @$content }}<br>
            Контактные данные:<br>
            <{{ @$email }}><br>
            Телефон: {{ @$phone }}
		</p>
	</div>
</body>
</html>
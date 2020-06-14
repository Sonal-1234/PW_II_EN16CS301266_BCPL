<!DOCTYPE html>
<html>
<head>
    <title>Invoice Email</title>
</head>
<body>
<div class="container">
    <h1> Hi User </h1>
    <p>
        This is your purchase order email. your account is expire on {{ $customerService->expire_date }}
        Please renew it.
        Thanks
    </p>
</div>
</body>
</html>
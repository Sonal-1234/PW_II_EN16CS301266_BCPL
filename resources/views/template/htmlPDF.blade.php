<!DOCTYPE html>
<html>
<head>
    <title>Laravel 5.8 HTML to PDF</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h1> Who is Batman ? </h1>
    <p>
        Batman is a fictional superhero appearing in American comic books published by DC Comics.
        The character was created by artist Bob Kane and writer Bill Finger,[1][2] and first appeared in Detective Comics #27 in 1939.
        Originally named the "Bat-Man," the character is also referred to by such epithets as the Caped Crusader, the Dark Knight, and the World's Greatest Detective.
        Batman's secret identity is Bruce Wayne, a wealthy American playboy, philanthropist, and owner of Wayne Enterprises. After witnessing the murder of his parents Dr. Thomas Wayne and Martha Wayne as a child, he
        swore vengeance against criminals, an oath tempered by a sense of justice. Bruce Wayne trains himself physically and intellectually and crafts a bat-inspired persona to fight crime.[6]</p>
    <form method="GET" action="/generatePDF58" enctype="multipart/form-data">
        <div class="form-group">
            <div class="control">
                <button type="submit" class="btn btn-primary">Generate PDF File</button>
            </div>
        </div>
    </form>
</body>
</html>
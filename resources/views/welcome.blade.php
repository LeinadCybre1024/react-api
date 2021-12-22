<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload</title>
</head>
<body>
 <form action="{{route('images')}}" method="POST"> 
@csrf
<label htmlFor="image">Upload Image to Laravel</label>
<input name="image" id="image" type="file" >
<button type="submit" >upload</button>
        </form>
</body>
</html>
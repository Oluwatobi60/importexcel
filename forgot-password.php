<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"  />
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-6 m-auto ">
        <h1 class="text-center mt-5">Forgot Password</h1>
       <form action="send-password-reset.php" method="POST">
            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email">
            <!--   <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
            </div>
            <div class="form-check mt-2">
            <button type="submit" class="btn btn-primary">Send</button>
            </div>
      </form>
      </div>
    </div>
  </div>
</body>
</html>
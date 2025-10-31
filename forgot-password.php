<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ultimate Landmark School | Forgot Password</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
      min-height: 100vh;
      font-family: 'Montserrat', Arial, Helvetica, sans-serif;
    }
    .card {
      border-radius: 1.25rem;
      box-shadow: 0 4px 24px rgba(0,0,0,0.08), 0 1.5px 4px rgba(0,0,0,0.04);
      margin-top: 4rem;
    }
    .school-logo {
      width: 80px;
      height: 80px;
      object-fit: contain;
      margin-bottom: 1rem;
    }
    .brand {
      color: #185a9d;
      font-weight: 700;
      letter-spacing: 1px;
      font-size: 2rem;
    }
    .btn-primary {
      background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
      border: none;
      font-weight: 600;
      border-radius: 0.75rem;
    }
    .btn-primary:hover {
      background: linear-gradient(90deg, #185a9d 0%, #43cea2 100%);
    }
    .form-label {
      color: #185a9d;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-6">
      <div class="card p-4">
        <div class="text-center">
          <img src="image/uls-logo.png" alt="Ultimate Landmark School Logo" class="school-logo">
          <div class="brand mb-2">Ultimate Landmark School</div>
          <h4 class="mb-4">Forgot Password</h4>
        </div>
        <form action="send-password-reset.php" method="POST" autocomplete="off">
          <div class="mb-3">
            <label for="email" class="form-label">Enter your registered email address</label>
            <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Email address" required>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">Send Password Reset Link</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
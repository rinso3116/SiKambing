<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo lang('login_heading'); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <style>
    body {
      background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .login-card {
      border-radius: 15px;
      background: #fff;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .login-input-group .form-control {
      border-left: 0;
    }

    .login-input-group .input-group-text {
      background: #fff;
      border-right: 0;
    }

    .btn-primary {
      background-color: #667eea;
      border: none;
    }

    .btn-primary:hover {
      background-color: #5a67d8;
    }
  </style>
</head>

<body class="d-flex flex-column justify-content-center align-items-center vh-100">

  <!-- Logo -->
  <img src="<?php echo base_url('assets/assets/images/logo/sikambing.png'); ?>" alt="SiKambing Logo" class="mb-3" style="width: 200px; height: auto;">

  <!-- Card Login -->
  <div class="card login-card p-4 text-center" style="width: 400px;">
    <h2 class="mb-3 fw-bold"><?php echo lang('login_heading'); ?></h2>
    <p class="text-muted"><?php echo lang('login_subheading'); ?></p>

    <?php if (!empty($message)) : ?>
      <div id="infoMessage" class="alert alert-danger"><?php echo $message; ?></div>
    <?php endif; ?>

    <?php echo form_open("auth/login"); ?>

    <!-- Username / Email -->
    <div class="mb-3">
      <div class="input-group login-input-group">
        <span class="input-group-text"><i class="bi bi-person"></i></span>
        <?php echo form_input($identity + ['class' => 'form-control', 'placeholder' => 'Email atau Username']); ?>
      </div>
    </div>

    <!-- Password -->
    <div class="mb-3">
      <div class="input-group login-input-group">
        <span class="input-group-text"><i class="bi bi-lock"></i></span>
        <?php echo form_input($password + ['class' => 'form-control', 'placeholder' => 'Password']); ?>
      </div>
    </div>

    <!-- reCAPTCHA -->
    <div class="mb-3">
      <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('recaptcha_site_key'); ?>"></div>
    </div>

    <!-- Login Button -->
    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold"> <?php echo lang('login_submit_btn'); ?> </button>
    <?php echo form_close(); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo lang('login_heading'); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
  <div class="card shadow p-4" style="width: 400px;">
    <h2 class="text-center mb-3"><?php echo lang('login_heading'); ?></h2>
    <p class="text-center text-muted"><?php echo lang('login_subheading'); ?></p>

    <?php if (!empty($message)) : ?>
      <div id="infoMessage" class="alert alert-danger"> <?php echo $message; ?> </div>
    <?php endif; ?>

    <?php echo form_open("auth/login"); ?>
    <div class="mb-3">
      <?php echo lang('login_identity_label', 'identity'); ?>
      <?php echo form_input($identity + ['class' => 'form-control', 'placeholder' => 'Enter your email or username']); ?>
    </div>

    <div class="mb-3">
      <?php echo lang('login_password_label', 'password'); ?>
      <?php echo form_input($password + ['class' => 'form-control', 'placeholder' => 'Enter your password']); ?>
    </div>

    <div class="form-check mb-3">
      <?php echo form_checkbox('remember', '1', FALSE, 'class="form-check-input" id="remember"'); ?>
      <label class="form-check-label" for="remember"> <?php echo lang('login_remember_label'); ?> </label>
    </div>

    <button type="submit" class="btn btn-primary w-100"> <?php echo lang('login_submit_btn'); ?> </button>
    <?php echo form_close(); ?>

    <div class="text-center mt-3">
      <a href="forgot_password" class="text-decoration-none"> <?php echo lang('login_forgot_password'); ?> </a>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
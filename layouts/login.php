<?php
 require_once('header.php');

?>

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
  <form method="POST" id="loginForm" class="border p-5 rounded shadow">
    <input type="hidden" name="action" value="login">
    <h2 class="text-center mb-4">Login</h2>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Email address</label>
      <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
      <div id="emailHelp" class="form-text"></div>
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Password</label>
      <input type="password" class="form-control" id="exampleInputPassword1" name="password">
    </div>
    <div class="mb-3 form-check">
      <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember">
      <label class="form-check-label" for="exampleCheck1">Remember Me</label>
    </div>
    <button type="submit" class="btn btn-primary w-100">Submit</button>
  </form>
</div>
<?php

include_once 'footer.php';

?>
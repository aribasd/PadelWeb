<!DOCTYPE html>
<html>
<head>
<style>
body {
  background-color: rgb(49, 49, 49);
  display: flex;
  justify-content: center;
  align-items: center;   
  height: 100vh;          
  margin-right: 0;              
}

button {
  padding: 40px 50px;
  width: 200px;
  height: 60px;
  text-transform: uppercase;
  border-radius: 8px;
  font-size: 24px;
  font-weight: 500;
  background: rgba(128, 128, 128, 0.5);
  text-shadow: none;
  background: transparent;
  cursor: pointer;
  box-shadow: transparent;
  border: 1px solid #ffffff80;
  transition: 0.5s ease;
  user-select: none;
}

#btn:hover,
:focus {
  color: #ffffff;
  background: #008cff;
  border: 1px solid #008cff;
  text-shadow: 0 0 5px #ffffff, 0 0 10px #ffffff, 0 0 20px #ffffff;
  box-shadow: 0 0 5px #008cff, 0 0 20px #008cff, 0 0 50px #008cff,
    0 0 100px #008cff;
}

</style>

<script src="https://cdn.tailwindcss.com"></script>

<link href="https://cdn.jsdelivr.net/npm/daisyui@4/dist/full.min.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div
  class="hero min-h-screen"
  style="background-image: url(https://images.unsplash.com/photo-1646649853703-7645147474ba?fm=jpg&q=60&w=3000&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8cGlzdGElMjBkZSUyMHAlQzMlQTFkZWx8ZW58MHx8MHx8fDA%3D);"
>
  <div class="hero-overlay"></div>
  <div class="hero-content text-neutral-content text-center">
    <div class="max-w-md">
      <h1 class="mb-5 text-5xl font-bold">SocialPadel</h1>
      <p class="mb-5">
        Reserva pistes, comparteix amb amics i segueix el teu progrés en la teva comunitat de pàdel.
      </p>
      <a href= "{{ route('login') }}">  <button id="btn">Login</button></a>
    <a href= "{{ route('login') }}">  <button id="btn">Register</button></a>
    </div>
  </div>
</div>
 
</body>


</html> 
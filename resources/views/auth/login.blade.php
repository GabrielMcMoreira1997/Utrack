<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UTrack - Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#FAFAFA] text-[#333] font-sans">

  <!-- Header -->
  <header class="flex justify-between items-center p-6 max-w-6xl mx-auto">
    <div class="flex items-center gap-2">
      <a class="w-10 h-10 flex items-center gap-2" href="{{ route('home') }}">
        <img src="{{ asset('images/logo-transparente.png') }}" alt="UTrack Logo">
        <span class="text-2xl font-bold text-[#2ECC71]">UTrack</span>
      </a>
    </div>
    <nav class="flex items-center gap-4">
      <a href="/register" class="text-[#2ECC71] font-semibold hover:underline">Registrar</a>
    </nav>
  </header>

  <!-- Container Login -->
  <main class="max-w-md mx-auto mt-20 bg-white p-8 rounded-2xl shadow-md">
    <h1 class="text-3xl font-bold text-center mb-6">Login</h1>

    @if (session('status'))
      <div class="mb-4 text-green-600 font-semibold">
        {{ session('status') }}
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <!-- Email -->
      <div class="mb-4">
        <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
        <input id="email" type="email" name="email" :value="old('email')" required autofocus
          class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-[#2ECC71] focus:outline-none">
        @error('email')
          <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
        @enderror
      </div>

      <!-- Password -->
      <div class="mb-4">
        <label for="password" class="block text-gray-700 font-semibold mb-2">Senha</label>
        <input id="password" type="password" name="password" required
          class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-[#2ECC71] focus:outline-none">
        @error('password')
          <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
        @enderror
      </div>

      <!-- Remember Me -->
      <div class="mb-4 flex items-center">
        <input id="remember_me" type="checkbox" name="remember"
          class="rounded border-gray-300 text-[#2ECC71] focus:ring-[#2ECC71]">
        <label for="remember_me" class="ml-2 text-gray-600">Lembrar-me</label>
      </div>

      <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}"
            class="text-sm text-gray-600 hover:underline">Esqueceu sua senha?</a>
        @endif
        <button type="submit"
          class="bg-[#2ECC71] hover:bg-[#27ae60] text-white px-6 py-3 rounded-xl font-semibold transition">
          Entrar
        </button>
      </div>
    </form>
  </main>

  <!-- Footer -->
  <footer class="text-center py-6 text-[#666] mt-20">
    © 2025 UTrack - Todos os direitos reservados
  </footer>

</body>
</html>

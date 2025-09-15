<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UTrack - Registro</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
  <style>
    .step {
      display: none;
    }

    .step.active {
      display: block;
    }
  </style>
</head>

<body class="bg-[#FAFAFA] text-[#333] font-sans">

  <!-- Header -->
  <header class="flex justify-between items-center p-6 max-w-6xl mx-auto">
    <div class="flex items-center gap-2">
      <a class="w-10 h-10 flex items-center gap-2" href="{{ route('home') }}"><img
          src="{{ asset('images/logo-transparente.png') }}" alt="UTrack Logo">
        <span class="text-2xl font-bold text-[#2ECC71]">UTrack</span></a>
    </div>
    <nav class="flex items-center gap-4">
      <a href="/login" class="text-[#2ECC71] font-semibold hover:underline">Login</a>
    </nav>
  </header>

  <!-- Container -->
  <main class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-md">
    <h1 class="text-3xl font-bold text-center mb-6">Crie sua Conta</h1>

    <!-- Progress -->
    <div class="flex items-center justify-between mb-8">
      <div class="flex-1 text-center">
        <div id="circle1"
          class="w-10 h-10 mx-auto rounded-full flex items-center justify-center bg-[#2ECC71] text-white font-bold">1
        </div>
        <p class="mt-2 text-sm">Empresa</p>
      </div>
      <div class="flex-1 border-t-2 border-gray-200"></div>
      <div class="flex-1 text-center">
        <div id="circle2"
          class="w-10 h-10 mx-auto rounded-full flex items-center justify-center bg-gray-200 text-gray-600 font-bold">2
        </div>
        <p class="mt-2 text-sm">Usuário</p>
      </div>
      <div class="flex-1 border-t-2 border-gray-200"></div>
      <div class="flex-1 text-center">
        <div id="circle3"
          class="w-10 h-10 mx-auto rounded-full flex items-center justify-center bg-gray-200 text-gray-600 font-bold">3
        </div>
        <p class="mt-2 text-sm">Pagamento</p>
      </div>
    </div>

    <form id="register-form" method="POST" action="{{ route('register') }}">
      @csrf

      <!-- Step 1 -->
      <div class="step active" id="step1">
        <h2 class="text-xl font-semibold mb-4">Nome da Companhia</h2>
        <input type="text" name="company_name" placeholder="Ex: Minha Empresa LTDA"
          class="w-full p-3 border rounded-xl mb-6 focus:ring-2 focus:ring-[#2ECC71] focus:outline-none">

        <div class="flex justify-end">
          <button type="button" onclick="nextStep(2)"
            class="bg-[#2ECC71] text-white px-6 py-2 rounded-xl hover:bg-[#27ae60] transition">Próximo</button>
        </div>
      </div>

      <!-- Step 2 -->
      <div class="step" id="step2">
        <h2 class="text-xl font-semibold mb-4">Dados do Usuário</h2>
        <input type="text" name="user_name" placeholder="Seu nome"
          class="w-full p-3 border rounded-xl mb-4 focus:ring-2 focus:ring-[#2ECC71] focus:outline-none">
        <input type="email" name="user_email" placeholder="Seu email"
          class="w-full p-3 border rounded-xl mb-4 focus:ring-2 focus:ring-[#2ECC71] focus:outline-none">
        <input type="password" name="user_password" placeholder="Senha"
          class="w-full p-3 border rounded-xl mb-6 focus:ring-2 focus:ring-[#2ECC71] focus:outline-none">

        <div class="flex justify-between">
          <button type="button" onclick="prevStep(1)"
            class="px-6 py-2 rounded-xl border border-gray-300 hover:bg-gray-100 transition">Voltar</button>
          <button type="button" onclick="nextStep(3)"
            class="bg-[#2ECC71] text-white px-6 py-2 rounded-xl hover:bg-[#27ae60] transition">Próximo</button>
        </div>
      </div>

      <!-- Step 3 -->
      <div class="step" id="step3">
        <h2 class="text-xl font-semibold mb-4">Pagamento (Mock Stripe)</h2>

        <select name="plan"
          class="w-full p-3 border rounded-xl mb-4 focus:ring-2 focus:ring-[#2ECC71] focus:outline-none">
          <option value="soft">Soft - R$ 29,99</option>
          <option value="premium">Premium - R$ 49,99</option>
        </select>

        <select name="payment_method"
          class="w-full p-3 border rounded-xl mb-4 focus:ring-2 focus:ring-[#2ECC71] focus:outline-none">
          <option value="credit_card">Cartão de Crédito</option>
          <option value="debit_card">Cartão de Débito</option>
          <option value="pix">Pix</option>
        </select>
        <input type="text" name="card_number" placeholder="Número do Cartão"
          class="w-full p-3 border rounded-xl mb-4 focus:ring-2 focus:ring-[#2ECC71] focus:outline-none">
        <div class="flex gap-4 mb-4">
          <input type="text" name="exp_date" placeholder="MM/AA"
            class="w-1/2 p-3 border rounded-xl focus:ring-2 focus:ring-[#2ECC71] focus:outline-none">
          <input type="text" name="cvc" placeholder="CVC"
            class="w-1/2 p-3 border rounded-xl focus:ring-2 focus:ring-[#2ECC71] focus:outline-none">
        </div>

        <input type="text" name="card_name" placeholder="Nome no Cartão"
          class="w-full p-3 border rounded-xl mb-6 focus:ring-2 focus:ring-[#2ECC71] focus:outline-none">

        <div class="flex justify-between">
          <button type="button" onclick="prevStep(2)"
            class="px-6 py-2 rounded-xl border border-gray-300 hover:bg-gray-100 transition">Voltar</button>
          <button type="submit"
            class="bg-[#2ECC71] text-white px-6 py-2 rounded-xl hover:bg-[#27ae60] transition">Finalizar</button>
        </div>
      </div>
    </form>
  </main>

  <!-- Script steps -->
  <script>
    function nextStep(step) {
      document.querySelectorAll('.step').forEach(el => el.classList.remove('active'));
      document.getElementById('step' + step).classList.add('active');
      updateCircles(step);
    }

    function prevStep(step) {
      document.querySelectorAll('.step').forEach(el => el.classList.remove('active'));
      document.getElementById('step' + step).classList.add('active');
      updateCircles(step);
    }

    function updateCircles(step) {
      [1, 2, 3].forEach(i => {
        const circle = document.getElementById('circle' + i);
        if (i <= step) {
          circle.classList.remove('bg-gray-200', 'text-gray-600');
          circle.classList.add('bg-[#2ECC71]', 'text-white');
        } else {
          circle.classList.remove('bg-[#2ECC71]', 'text-white');
          circle.classList.add('bg-gray-200', 'text-gray-600');
        }
      });
    }

    function showToast(message) {
      const toast = document.getElementById('toast');
      toast.textContent = message;
      toast.classList.remove('hidden');
      setTimeout(() => {
        toast.classList.add('hidden');
      }, 5000);
    }

    document.getElementById('register-form').addEventListener('submit', function () {
      let card = document.querySelector('[name="card_number"]');
      card.value = card.value.replace(/\D/g, '');

      let exp = document.querySelector('[name="exp_date"]');
      exp.value = exp.value.replace(/\D/g, '');

      let cvc = document.querySelector('[name="cvc"]');
      cvc.value = cvc.value.replace(/\D/g, '');
    });

    @if ($errors->any())
      document.addEventListener("DOMContentLoaded", () => {
        // Mapear campos por step
        const stepFields = {
          1: ['company_name'],
          2: ['name', 'email', 'password'],
          3: ['plan', 'payment_method', 'card_number', 'exp_date', 'cvc', 'card_name'],
        };

        let errorStep = 1;
        @foreach ($errors->keys() as $field)
          for (const [step, fields] of Object.entries(stepFields)) {
            if (fields.includes("{{ $field }}")) {
              errorStep = step;
            }
          }
        @endforeach

        // Abrir step do erro
        nextStep(errorStep);

        // Mostrar toast
        showToast("{{ implode(' | ', $errors->all()) }}");
      });
    @endif
  </script>

  <div id="toast" class="hidden fixed bottom-5 right-5 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg"></div>
  <!-- Footer -->
  <footer class="text-center py-6 text-[#666] mt-10">
    © 2025 UTrack - Todos os direitos reservados
  </footer>
</body>

</html>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UTrack - Encurtador de URLs</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
  <style>
    body {
      background-color: #FAFAFA;
    }

    /* Animação de fade + slide */
    .fade-slide {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .fade-slide.active {
      opacity: 1;
      transform: translateY(0);
    }
  </style>
</head>

<body class="text-[#333] font-sans">

  <!-- Header -->
  <header class="flex justify-between items-center p-6 max-w-6xl mx-auto">
    <div class="">
      <a class="w-10 h-10 flex items-center gap-2" href="{{ route('home') }}"><img
          src="{{ asset('images/logo-transparente.png') }}" alt="UTrack Logo">
        <span class="text-2xl font-bold text-[#2ECC71]">UTrack</span></a>
    </div>
    <nav class="flex items-center gap-4">
      <a href="/login" class="text-[#2ECC71] font-semibold hover:underline">Login</a>
      <a href="/register" class="text-[#2ECC71] font-semibold hover:underline">Registrar</a>
    </nav>
  </header>

  <!-- Hero / Box de encurtamento -->
  <section class="text-center py-16 px-6">
    <h1 class="text-4xl md:text-5xl font-bold mb-6">Encurte. Compartilhe. <span class="text-[#2ECC71]">Analise.</span>
    </h1>

    <!-- Frases rotativas -->
    <div class="h-10 relative mb-6">
      <p class="fade-slide absolute w-full text-[#666]" id="phrase1">Uma plataforma de encurtamento de links robusta e
        confiável para otimizar suas campanhas de marketing.</p>
      <p class="fade-slide absolute w-full text-[#666]" id="phrase2">Ajudamos você a entender seu público através de
        análise de relatórios.</p>
      <p class="fade-slide absolute w-full text-[#666]" id="phrase3">Transforme cliques em insights valiosos para o
        crescimento do seu negócio.</p>
    </div>

    <!-- Badges -->
    <div class="flex flex-wrap justify-center gap-3 my-6">
      <span
        class="inline-flex items-center px-4 py-1 rounded-full border border-gray-300 text-sm text-gray-700 bg-white shadow-sm">
        <svg class="w-4 h-4 mr-2 text-[#2ECC71]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Links grátis válidos por 24h
      </span>

      <span
        class="inline-flex items-center px-4 py-1 rounded-full border border-gray-300 text-sm text-gray-700 bg-white shadow-sm">
        <svg class="w-4 h-4 mr-2 text-[#2ECC71]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M11 19V6m-4 6h8m-8 4h8m-4 4V6m-7 13h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
        Analytics detalhados no plano premium
      </span>
    </div>

    <!-- Box de encurtamento -->
    <div class="bg-white border border-[#E0E0E0] rounded-2xl p-6 shadow-md max-w-xl mx-auto" id="shorten-form-box">
      <form id="shorten-form" class="flex flex-col md:flex-row gap-3">
        <input type="url" id="url" name="url" placeholder="Cole sua URL aqui"
          class="flex-1 p-3 rounded-xl border border-[#E0E0E0] focus:ring-2 focus:ring-[#2ECC71] focus:outline-none">
        <button type="submit"
          class="bg-[#2ECC71] hover:bg-[#27ae60] text-white px-6 py-3 rounded-xl font-semibold transition">Encurtar</button>
      </form>
    </div>

    <div id="result" class="mt-4 hidden">
      <p class="text-gray-700">Seu link encurtado:</p>
      <a id="short-url" href="#" target="_blank" class="text-indigo-600 font-semibold"></a>
    </div>
  </section>

  <!-- Sessão de Benefícios -->
  <section class="py-16">
    <div class="max-w-6xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold text-gray-900">Por que escolher o UTrack?</h2>
      <p class="mt-3 text-gray-600">Mais que um simples encurtador, o UTrack oferece insights valiosos sobre seus links.
      </p>

      <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Encurtamento Instantâneo -->
        <div class="p-6 border rounded-xl shadow-sm hover:shadow-md transition">
          <div class="flex items-center justify-center w-12 h-12 mx-auto rounded-lg bg-green-50">
            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
          </div>
          <h3 class="mt-4 text-lg font-semibold text-gray-900">Encurtamento Instantâneo</h3>
          <p class="mt-2 text-gray-600">Crie links curtos em segundos, sem cadastro necessário para uso básico.</p>
        </div>

        <!-- Analytics Detalhados -->
        <div class="p-6 border rounded-xl shadow-sm hover:shadow-md transition">
          <div class="flex items-center justify-center w-12 h-12 mx-auto rounded-lg bg-blue-50">
            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
            </svg>
          </div>
          <h3 class="mt-4 text-lg font-semibold text-gray-900">Analytics Detalhados</h3>
          <p class="mt-2 text-gray-600">Acompanhe cliques, dispositivos, localização e horários de acesso em tempo real.
          </p>
        </div>

        <!-- Links Permanentes (Premium) -->
        <div class="p-6 border rounded-xl shadow-sm hover:shadow-md transition">
          <div class="flex items-center justify-center w-12 h-12 mx-auto rounded-lg bg-purple-50">
            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 8c-1.657 0-3 .843-3 2s1.343 2 3 2 3-.843 3-2-1.343-2-3-2zm0 0V6m0 10v-2m-4 2H8a4 4 0 010-8h.268M16 18h-.268a4 4 0 010-8H16" />
            </svg>
          </div>
          <h3 class="mt-4 text-lg font-semibold text-gray-900">Links Permanentes</h3>
          <p class="mt-2 text-gray-600">No plano Premium, seus links nunca expiram e podem ser usados sem limite de
            tempo.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Planos -->
  <section class="py-20 px-6">
    <h2 class="text-3xl font-bold text-center mb-12">Planos</h2>
    <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">

      <!-- Plano Free -->
      <div class="bg-white border border-[#E0E0E0] rounded-2xl p-8 shadow-sm text-center">
        <h3 class="text-2xl font-bold mb-4">Free</h3>
        <p class="text-[#666] mb-6">Ideal para quem precisa encurtar links temporários.</p>
        <ul class="text-left text-[#333] mb-6 space-y-2">
          <li>✔ Links ativos por 24h</li>
          <li>✔ Encurtamento rápido</li>
          <li>✘ Relatórios avançados</li>
        </ul>
        <a href="#shorten-form-box"
          class="bg-[#2ECC71] text-white px-6 py-3 rounded-xl hover:bg-[#27ae60] transition">Começar grátis</a>
      </div>

      <!-- Plano Premium -->
      <div class="bg-[#2ECC71] text-white rounded-2xl p-8 shadow-md text-center">
        <h3 class="text-2xl font-bold mb-4">Premium</h3>
        <p class="mb-6">Para empresas e criadores que precisam de dados detalhados.</p>
        <ul class="text-left mb-6 space-y-2">
          <li>✔ Links permanentes</li>
          <li>✔ Relatórios avançados de cliques</li>
          <li>✔ Painel de estatísticas</li>
          <li>✔ Suporte prioritário</li>
        </ul>
        <a href="{{ route('register') }}"
          class="bg-white text-[#2ECC71] px-6 py-3 rounded-xl hover:bg-[#F2F2F2] transition font-semibold">Assinar
          Premium</a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center py-6 text-[#666]">
    © 2025 UTrack - Todos os direitos reservados
  </footer>

  <!-- Script frases -->
  <script>
    const phrases = [
      document.getElementById("phrase1"),
      document.getElementById("phrase2"),
      document.getElementById("phrase3"),
    ];
    let index = 0;

    function showPhrase(i) {
      phrases.forEach((p, idx) => {
        p.classList.remove("active");
        if (idx === i) {
          p.classList.add("active");
        }
      });
    }

    showPhrase(index);
    setInterval(() => {
      index = (index + 1) % phrases.length;
      showPhrase(index);
    }, 4000);

    document.getElementById('shorten-form').addEventListener('submit', async function (e) {
      e.preventDefault();
      let url = document.getElementById('url').value;

      let response = await fetch("{{ route('shorten') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ url })
      });

      let data = await response.json();

      if (data.short_url) {
        document.getElementById('short-url').textContent = data.short_url;
        document.getElementById('short-url').href = data.short_url;
        document.getElementById('result').classList.remove('hidden');
      }
    });

  </script>

</body>

</html>
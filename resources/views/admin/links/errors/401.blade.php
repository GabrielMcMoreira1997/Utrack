<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Link Expirado - UTrack</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { background-color: #FAFAFA; color: #333333; font-family: 'Kantumruy Pro', sans-serif; }
  </style>
</head>
<body class="flex items-center justify-center min-h-screen px-4">

  <div class="max-w-lg w-full bg-white rounded-2xl shadow-lg p-8 border border-[#E0E0E0] text-center">

    <!-- Ícone -->
    <div class="flex items-center justify-center w-20 h-20 mx-auto rounded-full bg-red-100 mb-6">
      <svg class="w-10 h-10 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M12 9v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 
                 9-9 9 4.03 9 9z"/>
      </svg>
    </div>

    <!-- Título -->
    <h1 class="text-2xl font-bold mb-3">⚠️ Link Expirado</h1>

    <!-- Texto curto inicial -->
    <p class="text-[#666666] leading-relaxed mb-8">
      O link que você tentou acessar <span class="font-semibold">não está mais disponível</span>.  
    </p>

    <!-- Merchan -->
    <div class="bg-[#FAFAFA] border border-[#E0E0E0] rounded-xl p-6 text-left mb-8">
      <h2 class="text-lg font-semibold mb-3 text-[#2ECC71]">📊 Torne seus links inteligentes com o UTrack</h2>
      <p class="text-[#666666] text-sm leading-relaxed mb-4">
        Pare de perder cliques valiosos. Com o <span class="font-medium">UTrack</span> você pode:
      </p>
      <ul class="text-sm text-[#333333] space-y-2 mb-4 list-disc pl-5">
        <li>Encurtar e personalizar links com sua marca</li>
        <li>Acompanhar estatísticas em tempo real</li>
        <li>Definir expiração e redirecionamentos inteligentes</li>
        <li>Conhecer melhor seu público e aumentar resultados</li>
      </ul>
      <p class="text-[#666666] text-sm">
        Transforme links comuns em <span class="font-semibold">oportunidades de crescimento</span>.
      </p>
    </div>

    <!-- CTA -->
    <a href="{{ route('register') }}" 
       class="inline-block bg-[#2ECC71] text-white font-medium px-6 py-3 rounded-xl shadow-md hover:opacity-90 transition">
       🚀 Criar conta gratuita
    </a>

    <!-- Secundário -->
    <div class="mt-4">
      <a href="{{ url('/') }}" class="text-sm text-[#666666] hover:underline">
        Voltar para a Home
      </a>
    </div>
  </div>

</body>
</html>

# Utrack - Encurtador de Links SaaS

![Logo](readme_assets/logo-projeto.png)

O **Utrack** é um sistema **SaaS de encurtamento de links corporativos**, desenvolvido para empresas que desejam organizar, proteger e analisar acessos a links de forma profissional.
Com recursos avançados de segurança, relatórios em tempo real e uma experiência de usuário fluida, o Utrack vai além do encurtador tradicional, oferecendo ferramentas de gestão e monitoramento.

---

## 🚀 Principais Recursos

* **Encurtamento de Links Personalizados**
  Crie links curtos e fáceis de compartilhar, com suporte a subdomínios exclusivos da sua empresa.

* **Segurança Avançada**

  * Defina **data de expiração** para o link.
  * Proteja acessos com **senha**.
  * Links privados que exigem autenticação antes do acesso.

* **Organização Inteligente**

  * Adicione **tags** para categorizar links.
  * Insira **comentários** para contextualizar cada link.
  * Facilite a busca e a gestão em escala.

* **Relatórios em Tempo Real (via Reverb)**

  * Acompanhe cliques à medida que acontecem.
  * Dados sempre atualizados sem necessidade de recarregar a página.

* **Compartilhamento Simples**

  * Gere QR Codes para os links.
  * Compartilhe com apenas um clique.

---

## 📊 Relatórios Disponíveis

O Utrack oferece relatórios detalhados para análise de acessos:

1. **Por Localidade**
   Visualize de onde seus links estão sendo acessados, com mapa interativo via **Leaflet**.
   ![Relatório por Localidade](readme_assets/report-by-locations.png)

2. **Por Dispositivos e Navegadores**
   Entenda melhor os dispositivos e navegadores usados nos acessos.
   ![Relatório de Navegadores e Dispositivos](readme_assets/report-by-browsers-devices.png)

3. **Por Intervalo de Datas**
   Compare períodos específicos e visualize tendências de acessos.
   ![Relatório por Intervalo de Datas](readme_assets/report-by-range.png)

---

## 🖼️ Interface do Sistema

* **Página Inicial Pública**
  ![Home](readme_assets/home_page.png)

* **Registro em Etapas (Onboarding de Empresas)**

  * **Step 1**: Nome da empresa
    ![Registro Step 1](readme_assets/register-step-1.png)
  * **Step 2**: Dados do usuário
    ![Registro Step 2](readme_assets/register-step-2.png)
  * **Step 3**: Dados de pagamento
    ![Registro Step 3](readme_assets/register-step-3.png)

* **Login Público**
  ![Login](readme_assets/login.png)

* **Dashboard com Indicadores**
  ![Dashboard](readme_assets/dashboard.png)

* **Modal de Criação de Link**
  ![Criar Link](readme_assets/create-link.png)

* **Página de Link Expirado**
  ![Link Expirado](readme_assets/link_expired.png)

* **Página de Link Protegido por Senha**
  ![Link Privado](readme_assets/link_private.png)

---

## 🛠️ Tecnologias Utilizadas

* **Backend**: PHP + Laravel
* **Banco de Dados**: MARIADB
* **Frontend**: AdminLTE + TailwindCSS
* **Realtime**: Laravel Reverb
* **Mapas**: Leaflet

---

## 📦 Instalação

1. Clone o repositório:

   ```bash
   git clone https://github.com/seu-org/utrack.git
   cd utrack
   ```

2. Instale as dependências:

   ```bash
   composer install
   npm install && npm run build
   ```

3. Configure o arquivo `.env`:

   ```env
   APP_NAME=Utrack
   APP_URL=http://utrack.test

   DB_CONNECTION=mariadb
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=utrack
   DB_USERNAME=postgres
   DB_PASSWORD=secret

   BROADCAST_CONNECTION=reverb

   REVERB_APP_ID=
   REVERB_APP_KEY=
   REVERB_APP_SECRET=
   REVERB_HOST="localhost"
   REVERB_PORT=8080
   REVERB_SCHEME=http

   VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
   VITE_REVERB_HOST="${REVERB_HOST}"
   VITE_REVERB_PORT="${REVERB_PORT}"
   VITE_REVERB_SCHEME="${REVERB_SCHEME}"
   ```

4. Rode as migrations e seeders:

   ```bash
   php artisan migrate --seed
   ```

5. Inicie o servidor:

   ```bash
   php artisan serve
   php artisan reverb:start
   php artisan queue:work
   ```

---

## 🔐 Autenticação e Gestão de Empresas

* Cada empresa possui sua **própria conta SaaS**, podendo gerenciar equipes, definir roles e criar relatórios.
* O acesso à área administrativa só é liberado após o login.
* A área pública contempla o site de marketing e o processo de registro.

---

## 📈 Diferenciais do Utrack

* Relatórios em tempo real com **dados de acessos instantâneos**.
* Segurança robusta para links sensíveis.
* Interface amigável e moderna.
* Estrutura escalável para empresas de diferentes portes.
* Onboarding simplificado em **3 etapas**.

---

## 📄 Licença

Este projeto está sob a licença MIT. Consulte o arquivo `LICENSE` para mais detalhes.

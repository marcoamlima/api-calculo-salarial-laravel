# 📊 Laravel API - Cálculo de Salário (INSS, IRRF, Aumento)

Esta API em Laravel realiza o cálculo automático dos **descontos salariais** conforme as alíquotas de INSS e IRRF vigentes, além de permitir **aumentar salários** com base em um percentual fornecido.

## 🚀 Funcionalidades

- ✅ Cálculo de desconto de INSS conforme faixa salarial.
- ✅ Cálculo de desconto de IRRF com deduções.
- ✅ Cálculo de salário líquido.
- ✅ Simulação de aumento salarial por percentual.

## 🔧 Tecnologias Utilizadas

- Laravel 10+
- PHP 8+
- Composer

## 📦 Instalação

```bash
git clone https://github.com/seu-usuario/nome-do-projeto.git
cd nome-do-projeto
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
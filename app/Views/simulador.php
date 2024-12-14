<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulador Plazo Fijo</title>
    <link rel="stylesheet" href="public/simulador.css">
</head>

<body>
    <div class="inicio">
        <a href="https://www.pichincha.com" class="link-img"></a>
    </div>
    <div class="contenedor">
        <div class="texto_img">
            <h1>Depósito a plazo fijo - Plazodolar</h1>
            <p>El depósito a plazo fijo para rentabilizar tu dinero según el monto y plazo que elijas. Desde $500 y 31
                días.</p>
            <a href="https://bancaweb.pichincha.com/pichincha" class="invierte">invierte en linea</a>
        </div>
        <div class="simulador">
            <p>ingresa el monto a invertir</p>
            <input type="number" name="monto" id="monto" class="monto">
            <p class="error" id="errorMsg1"></p>
            <p>podras invertir entre $500 y $100,000,000</p>
            <h2>selecciona el tipo de plazo</h2>
            <div class="botones">
                <h2>Selecciona el tipo de plazo</h2>
                <button id="mesesBtn">Meses</button>
                <button id="diasBtn">Días</button>
                <div id="mesesMenu" class="menu">
                    <button>12 Meses</button>
                    <button>9 Meses</button>
                    <button>6 Meses</button>
                    <button id="otroMesesBtn">Otro Plazo</button>
                </div>
                <div id="diasMenu" class="menu">
                    <button>30 Días</button>
                    <button>60 Días</button>
                    <button>90 Días</button>
                    <button id="otroDiasBtn">Otro Plazo</button>
                </div>
                <div id="otroPlazo" class="otro-plazo">
                    <label for="inputPlazo">Ingresa el número de <span id="tipoPlazo"></span>:</label>
                    <input type="number" id="inputPlazo" />
                    <p class="error" id="errorMsg"></p>
                </div>
            </div>
            <a href="https://bancaweb.pichincha.com/pichincha" class="invierte">invierte en linea</a>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Banco Pichicncha</p>
    </footer>
    <script>
        const inputMonto = document.getElementById('monto');
        const mesesBtn = document.getElementById('mesesBtn');
        const diasBtn = document.getElementById('diasBtn');
        const mesesMenu = document.getElementById('mesesMenu');
        const diasMenu = document.getElementById('diasMenu');
        const otroPlazo = document.getElementById('otroPlazo');
        const otroMesesBtn = document.getElementById('otroMesesBtn');
        const otroDiasBtn = document.getElementById('otroDiasBtn');
        const inputPlazo = document.getElementById('inputPlazo');
        const tipoPlazo = document.getElementById('tipoPlazo');
        const errorMsg = document.getElementById('errorMsg');
        const errorMsg1 = document.getElementById('errorMsg1');
        let monto = 0; 
        let plazo = 0; 
        let plazoTipo = ''; 
        mesesBtn.addEventListener('click', () => {
            toggleMenu(mesesMenu);
            diasMenu.style.display = 'none';
            otroPlazo.style.display = 'none';
        });
        diasBtn.addEventListener('click', () => {
            toggleMenu(diasMenu);
            mesesMenu.style.display = 'none';
            otroPlazo.style.display = 'none';
        });
       
        const botonesMeses = mesesMenu.querySelectorAll('button:not(#otroMesesBtn)');
        const botonesDias = diasMenu.querySelectorAll('button:not(#otroDiasBtn)');

        botonesMeses.forEach((btn) => {
            btn.addEventListener('click', () => {
                plazoTipo = 'meses';
                plazo = parseInt(btn.textContent.split(' ')[0]); 
                ocultarMenus(); 
                verificarCamposYCalcular();
            });
        });
        botonesDias.forEach((btn) => {
            btn.addEventListener('click', () => {
                plazoTipo = 'días';
                plazo = parseInt(btn.textContent.split(' ')[0]); 
                ocultarMenus();
                verificarCamposYCalcular();
            });
        });
        otroMesesBtn.addEventListener('click', () => {
            tipoPlazo.textContent = 'meses';
            plazoTipo = 'meses';
            otroPlazo.style.display = 'block';
            mesesMenu.style.display = 'none';
        });
        
        otroDiasBtn.addEventListener('click', () => {
            tipoPlazo.textContent = 'días';
            plazoTipo = 'días';
            otroPlazo.style.display = 'block';
            diasMenu.style.display = 'none';
        });
        
        inputPlazo.addEventListener('input', () => {
            const plazoValue = parseInt(inputPlazo.value);
            if (isNaN(plazoValue)) {
                errorMsg.textContent = 'Debe ingresar un número válido.';
            } else if (plazoTipo === 'meses' && plazoValue <= 1) {
                errorMsg.textContent = 'Debe ingresar más de 1 mes.';
            } else if (plazoTipo === 'días' && plazoValue <= 31) {
                errorMsg.textContent = 'Debe ingresar más de 31 días.';
            } else {
                errorMsg.textContent = '';
                plazo = plazoValue;
                ocultarMenus(); 
                verificarCamposYCalcular();
            }
        });
        
        inputMonto.addEventListener('input', () => {
            const montoValue = parseFloat(inputMonto.value);
            if (isNaN(montoValue)) {
                errorMsg1.textContent = 'Debe ingresar un número válido.';
            } else if (montoValue < 500) {
                errorMsg1.textContent = 'El monto debe ser mayor o igual a $500.';
            } else if (montoValue > 100000000) {
                errorMsg1.textContent = 'El monto no puede exceder $100,000,000.';
            } else {
                errorMsg1.textContent = '';
                monto = montoValue;
                verificarCamposYCalcular();
            }
        });
        
        function ocultarMenus() {
            mesesMenu.style.display = 'none';
            diasMenu.style.display = 'none';
            otroPlazo.style.display = 'none';
        }
        
        function toggleMenu(menu) {
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }
        function verificarCamposYCalcular() {
            if (monto > 0 && plazo > 0) {
                calcularPlazoFijo();
            }
        }
        function calcularPlazoFijo() {
            const tasaInteres = 0.05;
            let periodo = 0;
       
            if (plazoTipo === 'meses') {
                periodo = plazo / 12; 
            } else if (plazoTipo === 'días') {
                periodo = plazo / 365; 
            }
            const resultado = monto * (1 + tasaInteres * periodo); 
            alert(`Con una inversión de $${monto.toFixed(2)} y un plazo de ${plazo} ${plazoTipo}, obtendrás: $${resultado.toFixed(2)}.`);
        }
    </script>
</body>

</html>
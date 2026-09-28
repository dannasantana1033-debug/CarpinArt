<!-- views/cotizaciones/crear.php -->

<style>
/* Estilos Elegantes y Profesionales - Madera Fina / CarpinArt */
body {
    background: linear-gradient(135deg, #f4eee6 0%, #ede3d8 100%);
    min-height: 100vh;
}

.cotizacion-container {
    max-width: 960px;
    margin: 3rem auto;
    padding: 3rem;
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 20px 45px rgba(44, 26, 15, 0.1);
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    border: 1px solid #d7ccc8;
}

.cotizacion-header {
    text-align: center;
    margin-bottom: 2.5rem;
    padding: 3rem 2rem;
    background: linear-gradient(135deg, #3e2723 100%, #2c1a16 0%);
    border-radius: 16px;
    color: #ffffff;
    box-shadow: 0 12px 30px rgba(44, 26, 15, 0.25);
    position: relative;
    overflow: hidden;
    border-bottom: 4px solid #d4af37;
}

.cotizacion-header::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(212, 175, 55, 0.08) 0%, transparent 60%);
    pointer-events: none;
}

.cotizacion-header h2 {
    font-size: 2.5rem;
    margin-bottom: 0.6rem;
    font-weight: 800;
    letter-spacing: -0.5px;
    color: #ffffff;
}

.cotizacion-header p {
    color: #d7ccc8;
    font-size: 1.15rem;
    font-weight: 400;
    max-width: 650px;
    margin: 0 auto;
}

/* Alertas de Flash Messages */
.alert {
    padding: 1.1rem 1.4rem;
    border-radius: 12px;
    margin-bottom: 2rem;
    font-size: 0.98rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.8rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
}

.alert-danger {
    background-color: #fde8e8;
    color: #9b1c1c;
    border: 1px solid #f8b4b4;
}

.alert-success {
    background-color: #def7ec;
    color: #03543f;
    border: 1px solid #84e1bc;
}

/* Secciones del Formulario tipo Tarjeta Elegante */
.form-section {
    margin-bottom: 2.2rem;
    background: #fbf9f7;
    padding: 2.2rem;
    border-radius: 16px;
    border: 1px solid #e7ded8;
    box-shadow: 0 4px 15px rgba(62, 39, 35, 0.03);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.form-section:hover {
    box-shadow: 0 8px 25px rgba(62, 39, 35, 0.08);
    border-color: #bcaaa4;
    transform: translateY(-2px);
}

.form-section-title {
    font-size: 1.25rem;
    color: #3e2723;
    border-left: 5px solid #d4af37;
    padding-left: 0.9rem;
    margin-bottom: 1.6rem;
    font-weight: 700;
    letter-spacing: 0.3px;
    display: flex;
    align-items: center;
    gap: 0.7rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    gap: 1.4rem;
}

.col-12 { grid-column: span 12; }
.col-6  { grid-column: span 6; }
.col-4  { grid-column: span 4; }

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: 600;
    color: #4e342e;
    margin-bottom: 0.5rem;
    font-size: 0.98rem;
}

.form-group label .required {
    color: #c62828;
}

.form-control {
    padding: 0.95rem 1.2rem;
    border: 2px solid #d7ccc8;
    border-radius: 10px;
    font-size: 1rem;
    background-color: #ffffff;
    color: #2c2c2c;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

.form-control:hover {
    border-color: #a1887f;
}

.form-control:focus {
    outline: none;
    border-color: #5d4037;
    background-color: #ffffff;
    box-shadow: 0 0 0 4px rgba(93, 64, 55, 0.12);
}

textarea.form-control {
    resize: vertical;
    min-height: 140px;
}

.help-text {
    font-size: 0.88rem;
    color: #795548;
    margin-top: 0.5rem;
    font-weight: 500;
}

/* Área de Carga de Archivo Estilo Artesanal */
.file-dropzone {
    border: 2px dashed #bcaaa4;
    padding: 2rem 1.5rem;
    text-align: center;
    border-radius: 12px;
    background-color: #ffffff;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 110px;
}

.file-dropzone:hover {
    background-color: #f4ede6;
    border-color: #5d4037;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(62, 39, 35, 0.08);
}

#preview-container {
    margin-top: 1.2rem;
    display: none;
    text-align: center;
}

#preview-image {
    max-width: 220px;
    max-height: 220px;
    border-radius: 12px;
    border: 3px solid #d7ccc8;
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

/* Botón de Envío Premium */
.form-actions {
    text-align: right;
    margin-top: 3rem;
    padding-top: 1.5rem;
    border-top: 2px solid #e7ded8;
}

.btn-submit {
    background: linear-gradient(135deg, #5d4037 0%, #3e2723 100%);
    color: #ffffff;
    border: none;
    padding: 1.25rem 3.2rem;
    font-size: 1.15rem;
    font-weight: 700;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 8px 25px rgba(62, 39, 35, 0.3);
    letter-spacing: 0.5px;
    border-bottom: 3px solid #d4af37;
}

.btn-submit:hover {
    background: linear-gradient(135deg, #4e342e 0%, #2c1a16 100%);
    box-shadow: 0 12px 30px rgba(62, 39, 35, 0.4);
    transform: translateY(-3px);
}

.btn-submit:active {
    transform: translateY(-1px);
}

/* Responsividad Móvil */
@media (max-width: 768px) {
    .col-6, .col-4 {
        grid-column: span 12;
    }
    .cotizacion-container {
        padding: 1.5rem;
        margin: 1rem;
    }
    .cotizacion-header {
        padding: 2rem 1rem;
    }
    .cotizacion-header h2 {
        font-size: 2rem;
    }
    .form-actions {
        text-align: center;
    }
    .btn-submit {
        width: 100%;
    }
}
</style>

<div class="cotizacion-container">
    <div class="cotizacion-header">
        <h2>Solicita tu Mueble a Medida</h2>
        <p>Cuéntanos tu idea. Diseñamos y fabricamos piezas exclusivas ajustadas a tus necesidades y espacio.</p>
    </div>

    <!-- Mostrar Mensajes Flash de Error o Éxito -->
    <?php if (class_exists('Session') && ($error = Session::getFlash('error'))): ?>
        <div class="alert alert-danger">
            <span>⚠️</span>
            <span><?= class_exists('Security') ? Security::sanitizeString($error) : htmlspecialchars($error); ?></span>
        </div>
    <?php endif; ?>

    <?php if (class_exists('Session') && ($success = Session::getFlash('success'))): ?>
        <div class="alert alert-success">
            <span>✨</span>
            <span><?= class_exists('Security') ? Security::sanitizeString($success) : htmlspecialchars($success); ?></span>
        </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>cotizacion/guardar" method="POST" enctype="multipart/form-data" id="form-cotizacion">
        
        <!-- Token CSRF Obligatorio -->
        <?php if (isset($csrfToken)): ?>
            <input type="hidden" name="csrf_token" value="<?= $csrfToken; ?>">
        <?php endif; ?>

        <!-- SECCIÓN 1: Detalles del Proyecto -->
        <div class="form-section">
            <div class="form-section-title">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                1. Información del Proyecto
            </div>
            <div class="form-grid">
                
                <div class="form-group col-12">
                    <label for="titulo_proyecto">Título del Proyecto <span class="required">*</span></label>
                    <input type="text" id="titulo_proyecto" name="titulo_proyecto" class="form-control" 
                           placeholder="Ej: Clóset flotante para habitación principal" required maxlength="150">
                </div>

                <div class="form-group col-12">
                    <label for="descripcion_diseno">Descripción Detallada <span class="required">*</span></label>
                    <textarea id="descripcion_diseno" name="descripcion_diseno" class="form-control" 
                              placeholder="Describe acabados, distribución interna (cajones, repisas), estilo deseado o restricciones del espacio..." required></textarea>
                </div>

            </div>
        </div>

        <!-- SECCIÓN 2: Especificaciones Técnicas y Medidas -->
        <div class="form-section">
            <div class="form-section-title">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                2. Materiales y Dimensiones Aprox. (cm)
            </div>
            <div class="form-grid">
                
                <div class="form-group col-12">
                    <label for="material_preferido_id">Material Preferido</label>
                    <select id="material_preferido_id" name="material_preferido_id" class="form-control">
                        <option value="">-- Seleccionar material (opcional) --</option>
                        <?php if (!empty($materiales)): ?>
                            <?php foreach ($materiales as $mat): ?>
                                <option value="<?= $mat['id']; ?>">
                                    <?= class_exists('Security') ? Security::sanitizeString($mat['nombre']) : htmlspecialchars($mat['nombre']); ?> 
                                    (<?= class_exists('Security') ? Security::sanitizeString($mat['tipo']) : htmlspecialchars($mat['tipo']); ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <span class="help-text">💡 Si no estás seguro, el carpintero te asesorará sobre la mejor opción.</span>
                </div>

                <div class="form-group col-4">
                    <label for="largo_cm">Largo (cm)</label>
                    <input type="number" step="0.1" id="largo_cm" name="largo_cm" class="form-control" placeholder="Ej: 180">
                </div>

                <div class="form-group col-4">
                    <label for="ancho_cm">Ancho / Profundidad (cm)</label>
                    <input type="number" step="0.1" id="ancho_cm" name="ancho_cm" class="form-control" placeholder="Ej: 60">
                </div>

                <div class="form-group col-4">
                    <label for="alto_cm">Alto (cm)</label>
                    <input type="number" step="0.1" id="alto_cm" name="alto_cm" class="form-control" placeholder="Ej: 210">
                </div>

            </div>
        </div>

        <!-- SECCIÓN 3: Referencias y Presupuesto -->
        <div class="form-section">
            <div class="form-section-title">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                3. Imagen de Referencia y Presupuesto
            </div>
            <div class="form-grid">
                
                <div class="form-group col-6">
                    <label for="presupuesto_estimado_cliente">Presupuesto Estimado ($)</label>
                    <input type="number" step="0.01" id="presupuesto_estimado_cliente" name="presupuesto_estimado_cliente" class="form-control" placeholder="Ej: 1500000">
                    <span class="help-text">💡 Tu presupuesto estimado nos ayuda a sugerir mejores materiales.</span>
                </div>

                <div class="form-group col-6">
                    <label>Plano o Foto de Referencia</label>
                    <div class="file-dropzone" onclick="document.getElementById('imagen_referencia').click();">
                        <svg width="30" height="30" fill="none" stroke="#5d4037" stroke-width="2" viewBox="0 0 24 24" style="margin-bottom: 8px;"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        <p style="margin: 0 0 4px 0; color: #3e2723; font-weight: 700;">Clic aquí para adjuntar una imagen</p>
                        <span class="help-text" style="margin: 0;">Formatos: JPG, PNG, WEBP (Máx. 5MB)</span>
                    </div>
                    <input type="file" id="imagen_referencia" name="imagen_referencia" accept="image/jpeg,image/png,image/webp" style="display: none;">
                </div>

                <div class="form-group col-12" id="preview-container">
                    <label>Vista previa de la imagen:</label>
                    <div>
                        <img id="preview-image" src="#" alt="Previsualización de la foto de referencia">
                    </div>
                </div>

            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="form-actions">
            <button type="submit" class="btn-submit">
                ✨ Enviar Solicitud de Cotización
            </button>
        </div>

    </form>
</div>

<script>
// Script nativo para previsualización dinámica de imágenes adjuntas
document.getElementById('imagen_referencia').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        previewContainer.style.display = 'none';
        previewImage.src = '#';
    }
});
</script>
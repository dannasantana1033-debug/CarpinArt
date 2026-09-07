<!-- views/cotizaciones/crear.php -->

<style>
/* Estilos Específicos para el Formulario de Cotización */
.cotizacion-container {
    max-width: 850px;
    margin: 2rem auto;
    padding: 2rem;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.cotizacion-header {
    text-align: center;
    margin-bottom: 2rem;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 1rem;
}

.cotizacion-header h2 {
    color: #3e2723; /* Tono madera cálido */
    font-size: 1.8rem;
    margin-bottom: 0.5rem;
}

.cotizacion-header p {
    color: #666;
    font-size: 0.95rem;
}

/* Alertas de Flash Messages */
.alert {
    padding: 1rem;
    border-radius: 6px;
    margin-bottom: 1.5rem;
    font-size: 0.95rem;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

/* Secciones del Formulario */
.form-section {
    margin-bottom: 1.8rem;
}

.form-section-title {
    font-size: 1.1rem;
    color: #5d4037;
    border-left: 4px solid #8d6e63;
    padding-left: 0.5rem;
    margin-bottom: 1.2rem;
    font-weight: 600;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    gap: 1.2rem;
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
    color: #333;
    margin-bottom: 0.4rem;
    font-size: 0.9rem;
}

.form-group label .required {
    color: #d32f2f;
}

.form-control {
    padding: 0.75rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 0.95rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: #8d6e63;
    box-shadow: 0 0 0 3px rgba(141, 110, 99, 0.2);
}

textarea.form-control {
    resize: vertical;
    min-height: 120px;
}

.help-text {
    font-size: 0.8rem;
    color: #777;
    margin-top: 0.3rem;
}

/* Área de Carga de Archivo */
.file-dropzone {
    border: 2px dashed #bcaaa4;
    padding: 1.5rem;
    text-align: center;
    border-radius: 6px;
    background-color: #fafafa;
    cursor: pointer;
    transition: background-color 0.2s;
}

.file-dropzone:hover {
    background-color: #f5f5f5;
}

#preview-container {
    margin-top: 1rem;
    display: none;
    text-align: center;
}

#preview-image {
    max-width: 200px;
    max-height: 200px;
    border-radius: 6px;
    border: 1px solid #ddd;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

/* Botón de Envío */
.form-actions {
    text-align: right;
    margin-top: 2rem;
    border-top: 1px solid #eee;
    padding-top: 1.5rem;
}

.btn-submit {
    background-color: #4e342e;
    color: #ffffff;
    border: none;
    padding: 0.85rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.2s, transform 0.1s;
}

.btn-submit:hover {
    background-color: #3e2723;
}

.btn-submit:active {
    transform: scale(0.99);
}

/* Responsividad para Móviles */
@media (max-width: 768px) {
    .col-6, .col-4 {
        grid-column: span 12;
    }
    .cotizacion-container {
        padding: 1.2rem;
        margin: 1rem;
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
    <?php if ($error = Session::getFlash('error')): ?>
        <div class="alert alert-danger">
            <?= Security::sanitizeString($error); ?>
        </div>
    <?php endif; ?>

    <?php if ($success = Session::getFlash('success')): ?>
        <div class="alert alert-success">
            <?= Security::sanitizeString($success); ?>
        </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>cotizacion/guardar" method="POST" enctype="multipart/form-data" id="form-cotizacion">
        
        <!-- Token CSRF Obligatorio -->
        <input type="hidden" name="csrf_token" value="<?= $csrfToken; ?>">

        <!-- SECCIÓN 1: Detalles del Proyecto -->
        <div class="form-section">
            <div class="form-section-title">1. Información del Proyecto</div>
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
            <div class="form-section-title">2. Materiales y Dimensiones Aprox. (cm)</div>
            <div class="form-grid">
                
                <div class="form-group col-12">
                    <label for="material_preferido_id">Material Preferido</label>
                    <select id="material_preferido_id" name="material_preferido_id" class="form-control">
                        <option value="">-- Seleccionar material (opcional) --</option>
                        <?php if (!empty($materiales)): ?>
                            <?php foreach ($materiales as $mat): ?>
                                <option value="<?= $mat['id']; ?>">
                                    <?= Security::sanitizeString($mat['nombre']); ?> (<?= Security::sanitizeString($mat['tipo']); ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <span class="help-text">Si no estás seguro, el carpintero te asesorará sobre la mejor opción.</span>
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
            <div class="form-section-title">3. Imagen de Referencia y Presupuesto</div>
            <div class="form-grid">
                
                <div class="form-group col-6">
                    <label for="presupuesto_estimado_cliente">Presupuesto Estimado ($)</label>
                    <input type="number" step="0.01" id="presupuesto_estimado_cliente" name="presupuesto_estimado_cliente" class="form-control" placeholder="Ej: 1500000">
                    <span class="help-text">Tu presupuesto estimado nos ayuda a sugerir mejores materiales.</span>
                </div>

                <div class="form-group col-6">
                    <label>Plano o Foto de Referencia</label>
                    <div class="file-dropzone" onclick="document.getElementById('imagen_referencia').click();">
                        <p style="margin: 0; color: #555;">📎 Clic aquí para adjuntar una imagen</p>
                        <span class="help-text">Formatos permitidos: JPG, PNG, WEBP (Máx. 5MB)</span>
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
                🛠️ Enviar Solicitud de Cotización
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


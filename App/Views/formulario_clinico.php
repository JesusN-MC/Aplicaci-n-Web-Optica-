<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Óptica - Seguimiento de Cita</title>
  <link rel="stylesheet" href="../../CSS/formulario_clinico.css">
  <link rel="stylesheet" href="../../Components/Header/style.css">
  
</head>
<body>
    <?php include '../../Components/Header/header_servicios.php'; ?>
    <div class="container">
        <section class="appointment-info">
        <h2>Detalles de la Cita</h2>
        <div class="appointment-detail"><strong>Nombre:</strong> <span>xxxxxx</span></div>
        <div class="appointment-detail"><strong>Edad:</strong> <span>txx/xx/xxxx - xx/xx/xx</span></div>
        <div class="appointment-detail"><strong>Fecha y hora:</strong> <span>xxxxx</span></div>
        <div class="appointment-detail"><strong>Motivo:</strong> <span>xxxxx</span></div>
        <div class="appointment-detail"><strong>Descripción:</strong> <span>xxxxxxxxxxxxxxx</span></div>
        <div class="appointment-detail"><strong>Teléfono:</strong> <span>xxx-xxx-xxxx</span></div>
        </section>

        <section class="notes-section">
        <div class="notes-header">
            <h3>Notas de Seguimiento</h3>
            <button class="btn" id="addNote">+ Agregar nota</button>
        </div>
        <div id="notesList"></div>
        </section>
    </div>

  <script>
    const notesList = document.getElementById('notesList');
    const addNoteBtn = document.getElementById('addNote');

    function autoGrow(textarea) {
      textarea.style.height = 'auto';
      textarea.style.height = textarea.scrollHeight + 'px';
    }

    function createNoteElement(title = '', content = '') {
      const note = document.createElement('div');
      note.classList.add('note');
      note.innerHTML = `
        <div class="input-group">
          <textarea rows="1" required>${title}</textarea>
          <label>Título</label>
        </div>
        <div class="input-group">
          <textarea rows="2" required>${content}</textarea>
          <label>Contenido</label>
        </div>
        <div class="actions">
          <button class="btn btn-delete">Eliminar nota</button>
        </div>
      `;

      note.querySelectorAll('textarea').forEach(area => {
        area.addEventListener('input', () => autoGrow(area));
        autoGrow(area);
      });

      note.querySelector('.btn-delete').addEventListener('click', () => {
        note.remove();
        checkEmpty();
      });

      notesList.appendChild(note);
    }

    function checkEmpty() {
      if (notesList.children.length === 0) {
        createNoteElement('', '');
      }
    }

    addNoteBtn.addEventListener('click', () => createNoteElement('', ''));

    window.addEventListener('DOMContentLoaded', checkEmpty);
  </script>
</body>
</html>

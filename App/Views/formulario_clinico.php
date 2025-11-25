<?php
// Recibe id de cita
$id_cita = isset($_GET["id_cita"]) ? intval($_GET["id_cita"]) : 0;

require_once "../Models/Nota.php";
$notasObj = new Nota();

$notas = $notasObj->listarPorCita($id_cita);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Óptica - Seguimiento de Cita</title>
  <link rel="stylesheet" href="../../CSS/formulario_clinico.css">
  <link rel="stylesheet" href="../../Components/Header/style.css">
</head>

<body style="display:flex; justify-content:center; margin-top: 80px; flex-direction: row;">
    <?php include '../../Components/Header/header_servicios.php'; ?>

    <div class="container">

        <section class="appointment-info">
            <h2>Detalles de la Cita</h2>
            <div class="appointment-detail"><strong>Nombre:</strong> <span>xxxxxx</span></div>
            <div class="appointment-detail"><strong>Edad:</strong> <span>txx/xx/xxxx - xx/xx/xx</span></div>
            <div class="appointment-detail"><strong>Fecha y hora:</strong> <span>xxxxx</span></div>
            <div class="appointment-detail"><strong>Motivo:</strong> <span>xxxxx</span></div>
            <div class="appointment-detail"><strong>Descripción:</strong> <span>xxxxxxxxxxxxxxx</span></div>
        </section>

        <section class="notes-section">
            <div class="notes-header">
                <h3>Notas de Seguimiento</h3>
                <button type="button" class="btn" id="addNote">+ Agregar nota</button>
            </div>

            <form action="guardar_nota.php" method="POST">
                <input type="hidden" name="fk_cita" value="<?= $id_cita ?>">

                <div id="notesList"></div>

                <button class="btn" style="margin-top:20px;" type="submit">
                    Guardar cambios
                </button>
            </form>
        </section>

    </div>

<script>
  const notesList = document.getElementById("notesList");
  const addNoteBtn = document.getElementById("addNote");

  function autoGrow(textarea) {
      textarea.style.height = "auto";
      textarea.style.height = textarea.scrollHeight + "px";
  }

  function createNoteElement(id = "", title = "", content = "") {
      const note = document.createElement("div");
      note.classList.add("note");

      note.innerHTML = `
          <input type="hidden" name="id_nota[]" value="${id}">

          <div class="input-group">
              <textarea name="titulo[]" rows="1" required>${title}</textarea>
              <label>Título</label>
          </div>

          <div class="input-group">
              <textarea name="contenido[]" rows="2" required>${content}</textarea>
              <label>Contenido</label>
          </div>

          <div class="actions">
              <button type="button" class="btn btn-delete">Eliminar nota</button>
          </div>
      `;

      note.querySelectorAll("textarea").forEach(area => {
          area.addEventListener("input", () => autoGrow(area));
          autoGrow(area);
      });

      note.querySelector(".btn-delete").addEventListener("click", () => {
          // Si la nota existe en BD, marcamos su eliminación
          if (id !== "") {
              const hidden = document.createElement("input");
              hidden.type = "hidden";
              hidden.name = "eliminar[]";
              hidden.value = id;
              notesList.appendChild(hidden);
          }

          note.remove();
          checkEmpty();
      });

      notesList.appendChild(note);
  }

  function checkEmpty() {
      if (notesList.children.length === 0) {
          createNoteElement("", "", "");
      }
  }

  window.addEventListener("DOMContentLoaded", () => {
      const notasBD = <?= json_encode($notas) ?>;

      if (notasBD.length > 0) {
          notasBD.forEach(n =>
              createNoteElement(n.id, n.titulo, n.contenido)
          );
      } else {
          createNoteElement("", "", "");
      }
  });

  addNoteBtn.addEventListener("click", () => {
      createNoteElement("", "", "");
  });
</script>


</body>
</html>

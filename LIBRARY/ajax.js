function fetchNotes() {
    const bookId = $("#bookId").val();
    $.ajax({
      type: "GET",
      url: "get-notes.php",
      data: {
        bookId,
      },
      dataType: "json",
      success: function (notes) {
        const notesList = $("#userNotesList");
        notesList.empty();
  
        if (notes.length > 0) {
          notes.forEach(function (note) {
            notesList.append(`<li>
                <span>${note.note}</span>
                <button class="btn btn-sm btn-warning mx-2" onclick="editNote(${note.id})">Edit</button>
                <button class="btn btn-sm btn-danger" onclick="deleteNote(${note.id})">Delete</button>
              </li>`);
          });
        } else {
          notesList.append("<li>No private notes available.</li>");
        }
      },
      error: function (error) {
        console.error(error);
      },
    });
  }
  
  function addNote() {
    const noteContent = $("#noteContent").val();
    const bookId = $("#bookId").val();
  
    if (!noteContent.trim()) {
      alert("Please enter a note.");
      return;
    }
  
    $.ajax({
      type: "POST",
      url: "add-note.php",
      data: {
        noteContent,
        bookId,
      },
      dataType: "json",
      success: function (response) {
        if (response.success) {
          $("#noteMessage")
            .text("Note added successfully.")
            .removeClass("text-danger")
            .addClass("text-success");
          $("#noteContent").val("");
  
          fetchNotes();
        } else {
          $("#noteMessage")
            .text("Error adding note. Please try again.")
            .removeClass("text-success")
            .addClass("text-danger");
        }
      },
      error: function (error) {
        console.error(error);
      },
    });
  }
  
  function editNote(noteId) {
    const newNoteContent = prompt("Enter the new note content:");
    if (newNoteContent !== null) {
      $.ajax({
        type: "POST",
        url: "edit-note.php",
        data: {
          noteId,
          newNoteContent,
        },
        dataType: "json",
        success: function (response) {
          console.log(response);
          $("#noteMessage")
            .text(response.success)
            .removeClass("text-danger")
            .addClass("text-success");
          updateNotesList();
  
          fetchNotes();
        },
        error: function (error) {
          console.error(error);
          $("#noteMessage")
            .text("Error updating note. Please try again.")
            .removeClass("text-success")
            .addClass("text-danger");
        },
      });
    }
  }
  
  function deleteNote(noteId) {
    if (confirm("Are you sure you want to delete this note?")) {
      const bookId = $("#bookId").val();
      $.ajax({
        type: "POST",
        url: "delete-note.php",
        data: {
          noteId,
          bookId,
        },
        dataType: "json",
        success: function (response) {
          console.log(response);
          $("#noteMessage")
            .text(response.success)
            .removeClass("text-danger")
            .addClass("text-success");
          updateNotesList();
  
          fetchNotes();
        },
        error: function (error) {
          console.error(error);
          $("#noteMessage")
            .text("Error deleting note. Please try again.")
            .removeClass("text-success")
            .addClass("text-danger");
        },
      });
    }
  }
  
  function updateNotesList() {
    fetchNotes();
  }
  
  $(document).ready(function () {
    fetchNotes();
  });
  
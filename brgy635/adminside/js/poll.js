
  let polls = [];
  let reasoning = "";

  function addOptionField() {
    const container = document.getElementById('optionFields');
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'options[]';
    input.placeholder = 'New Option';
    input.required = true;
    container.appendChild(input);
}

function editPoll(id, question, options, username) {
    document.getElementById('poll_id').value = id;
    document.getElementById('question').value = question;
    document.getElementById('created_by').value = username;

    const container = document.getElementById('optionFields');
    container.innerHTML = '';
    options.forEach(opt => {
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'options[]';
        input.value = opt;
        input.required = true;
        container.appendChild(input);
    });
  }

    document.getElementById('formTitle').innerText = "Update Poll";

function resetForm() {
    document.getElementById("poll_id").value = "";
    document.getElementById("question").value = "";
    document.getElementById("created_by").value = "";
    document.getElementById("formTitle").innerText = "Add Poll";
    const optionContainer = document.getElementById("optionFields");
    optionContainer.innerHTML = `
        <input type="text" name="options[]" placeholder="Option 1" required>
        <input type="text" name="options[]" placeholder="Option 2" required>
    `;
}
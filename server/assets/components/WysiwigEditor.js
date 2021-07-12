import Quill from 'quill';

export default class WysiwigEditor {
  constructor(input) {
    const inputClone = input;
    const form = inputClone.closest('form');
    const container = inputClone.closest('div');

    inputClone.insertAdjacentHTML(
      'beforebegin',
      '<div class="quill-editor"></div>'
    );
    const editor = container.querySelector('.quill-editor');
    editor.innerHTML = inputClone.value;
    editor.className += inputClone.className;

    const toolbarOptions = [
      ['bold', 'italic'],

      [{ header: [4, false] }],

      ['clean'], // remove formatting button
    ];
    const quill = new Quill(editor, {
      modules: {
        toolbar: toolbarOptions,
      },
      theme: 'snow',
    });

    inputClone.style.display = 'none';

    form.addEventListener('submit', () => {
      inputClone.value = quill.root.innerHTML;
    });
  }
}

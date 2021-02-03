import { render, screen } from '@testing-library/svelte';
import userEvent from '@testing-library/user-event';

import FormInput from './FormInput.svelte';

test('shows proper label and nme when rendered', () => {
  const { getByPlaceholderText } = render(FormInput, {
    name: 'foo',
    type: 'email',
    label: 'foo',
    value: 'value',
  });

  expect(getByPlaceholderText('foo')).toBeInTheDocument();
});

test('should be able to write in the input', () => {
  const text = 'hello world';
  const inputName = 'dummy';
  render(FormInput, {
    name: inputName,
    type: 'password',
    label: inputName,
    value: 'value',
  });
  userEvent.type(screen.getByPlaceholderText(inputName), text);
  expect(screen.getByLabelText(inputName)).toBeInTheDocument();
});

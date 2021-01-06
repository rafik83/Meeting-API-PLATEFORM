import { render } from '@testing-library/svelte';
import App from './App.svelte';

describe('App', () => {
  it('should render', () => {
    const results = render(App, { props: { name: 'world' } });
    expect(() => results.getByText('Hello world!')).not.toThrow();
  });
});

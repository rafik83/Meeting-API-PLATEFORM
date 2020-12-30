import { render } from '@testing-library/svelte';

import Greeter from './Greeter.svelte';

describe('Greeter', () => {
  it('should display the Greeter component when rendered', () => {
    const { getAllByTestId } = render(Greeter);
    expect(getAllByTestId('greeter')[0]).toBeInTheDocument();
  });
});

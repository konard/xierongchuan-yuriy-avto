import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';

function LeadStatus() {
  return (
    <span className="badge" data-testid="react-lead-status">
      React UI ready
    </span>
  );
}

const mount = document.querySelector('[data-react-lead-status]');

if (mount) {
  createRoot(mount).render(<LeadStatus />);
}

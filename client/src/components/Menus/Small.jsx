import React from 'react';
import { PopoverBody, Popover } from 'reactstrap';

export default ({ isOpen, toggle, children }) => (
  <Popover isOpen={isOpen} toggle={toggle} target="TrelloWorkflow">
    <PopoverBody>
      {children}
    </PopoverBody>
  </Popover>
);

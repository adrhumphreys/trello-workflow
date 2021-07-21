import React from 'react';
import { DropdownItem } from 'reactstrap';

function viewItOnTrello(trelloLink, viewOnTrelloText = 'View card on Trello') {
  return (trelloLink && trelloLink.length > 0 ? (
    <div>
      <DropdownItem divider role="separator" />
      <DropdownItem><a href={trelloLink}>{viewOnTrelloText}</a></DropdownItem>
    </div>
  ) : null);
}

export const WorkflowSelector = ({
  options,
  selected,
  setActiveWorkflow,
  trelloLink,
  viewOnTrelloText,
  MenuComponent,
  isOpen,
  toggle
}) => {
  const renderOption = ({ id, title }) => (
    <DropdownItem
      onClick={() => setActiveWorkflow(id)}
      active={id === selected}
    >
      {title}
    </DropdownItem>
  );

  return (
    <MenuComponent isOpen={isOpen} toggle={toggle}>
      {options && options.map(renderOption)}
      {viewItOnTrello(trelloLink, viewOnTrelloText)}
    </MenuComponent>
  );
};

export default WorkflowSelector;

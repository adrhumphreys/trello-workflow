import Injector from 'lib/Injector';
import WorkflowWidget from '../components/WorkflowWidget';

export default () => {
  Injector.component.registerMany({
    WorkflowWidget
  });
};

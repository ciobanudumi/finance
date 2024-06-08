import { useSelector } from 'react-redux';
import { selectUser } from '../../containers/App/selectors';
import { useNavigate } from 'react-router-dom';

function ProtectedRoute({ children }) {
  const user = useSelector(selectUser);
  const navigate = useNavigate();

  if (!user) {
    navigate('/login');
  }

  return children;
}

export default ProtectedRoute;

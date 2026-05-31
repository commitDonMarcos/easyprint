import apiClient from './client';

export const uploadLogo = (file) => {
  const formData = new FormData();
  formData.append('image', file);
  return apiClient.post('/logos/upload', formData, {
    headers: { 'Content-Type': 'multipart/form-data' },
  });
};

export const deleteLogo = (path) => apiClient.delete('/logos', { data: { path } });

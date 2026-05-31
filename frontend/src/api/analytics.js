import apiClient from './client';

export const trackEvent = (action, templateId = null, metadata = null) =>
  apiClient.post('/analytics/track', { action, template_id: templateId, metadata });

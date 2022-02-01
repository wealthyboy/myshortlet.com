export const message = (state) => {
  return state.message;
};

export const reviewsMeta = (state) => {
  return state.reviewsMeta;
};

export const reviews = (state) => {
  return state.reviews;
};

export const comments = (state) => {
  return state.comments;
};

export const images = (state) => {
  return state.images;
};

export const notification = (state) => {
  return state.notification;
};

export const wishlistCount = (state) => {
  return state.wishlist.length;
};

export const wishlist = (state) => {
  return state.wishlist;
};

export const loggedIn = (state) => {
  return state.loggedIn;
};

export const addresses = (state) => {
  return state.addresses;
};

export const locations = (state) => {
  return state.locations;
};

export const voucher = (state) => {
  return state.voucher;
};

export const total = (state) => {
  return state.total;
};

export const shipping = (state) => {
  return state.shipping;
};

export const default_shipping = (state) => {
  return state.default_shipping;
};

export const errors = (state) => {
  return state.errors;
};

export const loading = (state) => {
  return state.loadn;
};

export const user = (state) => {
  return state.user;
};

export const showForm = (state) => {
  return state.showForm;
};

export const edit = (state) => {
  return state.editMode;
};

export const userType = (state) => {
  return state.userType;
};

export const properties = (state) => {
  return state.properties.filter((property) => !property.reservation_id);
};

export const attributes = (state) => {
  return state.attributes;
};

export const propertyLoading = (state) => {
  return state.propertyLoading;
};

export const attributesCheckboxes = (state) => {
  return state.attributesCheckboxes;
};

export const locationSearch = (state) => {
  return state.locationSearch;
};

export const links = (state) => {
  return state.links;
};

export const next_page_url = (state) => {
  return state.next_page_url;
};

export const bookings = (state) => {
  return state.bookings;
};

export const bookingTotal = (state) => {
  return state.bookingTotal;
};

export const bookingSubTotal = (state) => {
  return state.bookingSubTotal;
};

export const bookingServicesTotal = (state) => {
  return state.bookingServicesTotal;
};

export const bookingPropertyServicesTotal = (state) => {
  return state.bookingPropertyServicesTotal;
};

export const meta = (state) => {
  return state.meta;
};

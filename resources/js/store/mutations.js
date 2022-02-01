import { lowerFirst } from "lodash";

export const setCoupon = (state, voucher) => {
  state.voucher.push(voucher);
};

export const setMessage = (state, message) => {
  state.message = message;
};

export const setReviews = (state, reviews) => {
  state.reviews = reviews;
};

export const setComments = (state, comments) => {
  state.comments = comments;
};

export const Loading = (state, trueOrFalse) => {
  state.loadn = trueOrFalse;
};

export const setReviewsMeta = (state, meta) => {
  state.reviewsMeta = meta;
};

export const setShowForm = (state, trueOrFalse) => {
  state.showForm = trueOrFalse;
};

export const setNotification = (state, notification) => {
  state.notification = notification;
};

export const clearMessage = (state, meta) => {
  state.message = null;
};

export const setWishlist = (state, wishlist) => {
  state.wishlist = wishlist;
};

export const setUser = (state, user) => {
  state.user = user;
};

export const setLoggedIn = (state, auth) => {
  state.loggedIn = auth;
};

export const setEditMode = (state, trueOrFalse) => {
  state.editMode = trueOrFalse;
};

export const setFormErrors = (state, errors) => {
  state.errors = errors;
};

export const setUserType = (state, type) => {
  state.userType = type;
};

export const setProperties = (state, p) => {
  state.properties = p;
};

export const setAttributes = (state, a) => {
  state.attributes = a;
};

export const setIsSaved = (state, p) => {
  state.properties = p;
};

export const setPropertyLoading = (state, l) => {
  state.propertyLoading = l;
};

export const setAttributesCheckboxes = (state, c) => {
  state.attributesCheckboxes = c;
};

export const setLocationSearch = (state, location) => {
  state.locationSearch = location;
};

export const setLinks = (state, links) => {
  state.links.push(links);
};

export const setNextPageUrl = (state, links) => {
  state.next_page_url = links;
};

export const setBookings = (state, bookings) => {
  state.bookings = bookings;
};

export const setBookingTotal = (state, total) => {
  state.bookingTotal = total;
};

export const setBookingSubTotal = (state, total) => {
  state.bookingSubTotal = total;
};

export const setBookingServicesTotal = (state, total) => {
  state.bookingServicesTotal = total;
};

export const setBookingPropertyServicesTotal = (state, total) => {
  state.bookingPropertyServicesTotal = total;
};

export const setMeta = (state, meta) => {
  state.meta = meta;
};

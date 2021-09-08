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

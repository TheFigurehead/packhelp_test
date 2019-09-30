import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class RelatedPost extends Component{
    constructor(){
        super();
        this.state  = {
            post: false
        }
    }
    componentDidMount(){
        const { post } = this.props;
        this.setState({ post });
    }
    render () {
        const {state: { post }} = this;    
        return (
            <div className="col-md-4">
                <div className="card mb-4 shadow-sm">
                    <img src={post.thumbnail} alt={post.title} />
                    <div className="card-body">
                        <p className="card-text">
                            {post.excerpt}
                        </p>
                        <div className="d-flex justify-content-between align-items-center">
                            <div className="btn-group">
                                <a href={post.permalink} className="btn btn-sm btn-outline-secondary">View</a>                           
                            </div>
                            <small className="text-muted">{post.date}</small>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

class  RelatedPosts  extends  Component {

    constructor(){
        super();
        this.state  = {
            posts: [],
            dataRoute:  "http://localhost:81/packhelp/wp-json/related/v1/product/" + packhelp_data.id + "/" + packhelp_data.user
        }
    }

    componentDidMount(){
        fetch(this.state.dataRoute)
            .then(res  =>  res.json())
            .then(posts  =>  this.setState((prevState, props) => {
                return { posts:  posts.map(this.mapPost) };
            }));
    }  

    mapPost(post){
        return {
            post_id: post.ID,
            title: post.title,
            permalink: post.permalink,
            excerpt: post.excerpt,
            date: post.date,
            thumbnail: post.thumbnail,
            editLink: post.editLink
        }
    }

    render(){
        return(
            <section className="related-products">
                <h2>Related Products</h2>
                <div className="row">
                    {this.state.posts.map((post, i) => {     
                        return ( <RelatedPost key={i} post={post} />) 
                    })}
                </div>
            </section>
        )
    }
}

document.addEventListener(
    'DOMContentLoaded',
    function(){
        var root_related = document.getElementById('root_related');
        if(root_related){
            ReactDOM.render(
                <RelatedPosts />,
                document.getElementById('root_related')
            );
        }
    }
);
